
import { useEffect, useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ActivityIndicator,
  ScrollView,
  TouchableOpacity,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import * as SecureStore from 'expo-secure-store';


const API_URL = 'http://172.20.10.3:8081';

type UserProfile = {
  id: number;
  username: string;
  email: string;
};

type Checkin = {
  id: number;
  date: string;
  created_at: number;
};

export default function DashboardScreen() {
  const [user, setUser] = useState<UserProfile | null>(null);
  const [checkins, setCheckins] = useState<Checkin[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [checkingIn, setCheckingIn] = useState(false);
  const [checkinMessage, setCheckinMessage] = useState('');

  useEffect(() => {
    loadDashboard();
  }, []);

  const loadDashboard = async () => {
    try {
      const token = await SecureStore.getItemAsync('userToken');

      if (!token) {
        setError('Your session has expired. Please log in again.');
        return;
      }

      const headers = {
        Authorization: `Bearer ${token}`,
      };

      // Load the user's profile.
      const profileResponse = await fetch(
        `${API_URL}/site/profile`,
        { headers }
      );

      const profileData = await profileResponse.json();

      if (!profileData.success) {
        setError('Could not load your profile.');
        return;
      }

      setUser(profileData.user);

      // Load the user's check-in history.
      const checkinsResponse = await fetch(
        `${API_URL}/site/checkins`,
        { headers }
      );

      const checkinsData = await checkinsResponse.json();

      if (checkinsData.success) {
        setCheckins(checkinsData.checkins);
      }
    } catch (error) {
      console.log('DASHBOARD ERROR:', error);
      setError('Could not connect to the server.');
    } finally {
      setLoading(false);
    }
  };

  // Submit today's check-in to the Yii2 API.
  const handleCheckin = async () => {
    // Prevent multiple requests if the user taps repeatedly.
    if (checkingIn) return;

    setCheckingIn(true);
    setCheckinMessage('');

    try {
      // Retrieve the authentication token saved during login.
      const token = await SecureStore.getItemAsync('userToken');

      if (!token) {
        setCheckinMessage('Your session has expired. Please log in again.');
        return;
      }

      // Send a POST request to our protected check-in endpoint.
      const response = await fetch(`${API_URL}/site/checkin`, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      const data = await response.json();

      // If the backend rejects the request, display its message.
      if (!response.ok || !data.success) {
        setCheckinMessage(
          data.message || 'Could not complete your check-in. Please try again.'
        );
        return;
      }

      // Show the confirmation returned by the backend.
      setCheckinMessage(data.message || 'Check-in completed successfully.');

      // Reload the dashboard to get updated check-in history and streak.
      await loadDashboard();

    } catch (error) {
      console.log('CHECK-IN ERROR:', error);
      setCheckinMessage('Connection failed. Please try again.');
    } finally {
      // Stop the loading state whether the request succeeds or fails.
      setCheckingIn(false);
    }
  };

  // Calculate the current consecutive check-in streak.
  const calculateStreak = () => {
    if (checkins.length === 0) return 0;

    const dates = checkins.map((checkin) => checkin.date);

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);

    const latestDate = new Date(`${dates[0]}T00:00:00`);
    latestDate.setHours(0, 0, 0, 0);

    // The streak remains active if the latest check-in
    // was today or yesterday.
    if (
      latestDate.getTime() !== today.getTime() &&
      latestDate.getTime() !== yesterday.getTime()
    ) {
      return 0;
    }

    let streak = 1;
    let currentDate = latestDate;

    for (let i = 1; i < dates.length; i++) {
      const previousDate = new Date(`${dates[i]}T00:00:00`);
      previousDate.setHours(0, 0, 0, 0);

      const expectedDate = new Date(currentDate);
      expectedDate.setDate(expectedDate.getDate() - 1);

      if (previousDate.getTime() === expectedDate.getTime()) {
        streak++;
        currentDate = previousDate;
      } else {
        break;
      }
    }

    return streak;
  };

  // Calculate the highest consecutive check-in streak ever achieved.
const calculateBestStreak = () => {
  if (checkins.length === 0) return 0;

  // Get all check-in dates and sort them from oldest to newest.
  const dates = checkins
    .map((checkin) => checkin.date)
    .sort();

  let bestStreak = 1;
  let currentStreak = 1;

  for (let i = 1; i < dates.length; i++) {
    const previousDate = new Date(`${dates[i - 1]}T00:00:00`);
    const currentDate = new Date(`${dates[i]}T00:00:00`);

    const difference =
      (currentDate.getTime() - previousDate.getTime()) /
      (1000 * 60 * 60 * 24);

    if (difference === 1) {
      currentStreak++;
    } else if (difference > 1) {
      currentStreak = 1;
    } else {
      // Ignore duplicate dates.
      continue;
    }

    bestStreak = Math.max(bestStreak, currentStreak);
  }

  return bestStreak;
};

  // Check whether the user has checked in today.
  const hasCheckedInToday = () => {
    const today = new Date();
    const todayString = [
      today.getFullYear(),
      String(today.getMonth() + 1).padStart(2, '0'),
      String(today.getDate()).padStart(2, '0'),
    ].join('-');

    return checkins.some(
      (checkin) => checkin.date === todayString
    );
  };

  // Display a greeting based on the current time.
  const getGreeting = () => {
    const hour = new Date().getHours();

    if (hour < 12) return 'Good morning';
    if (hour < 18) return 'Good afternoon';
    return 'Good evening';
  };

  // Format today's date for the dashboard.
  const formattedDate = new Date().toLocaleDateString(
    'en-US',
    {
      weekday: 'long',
      month: 'long',
      day: 'numeric',
    }
  );

  if (loading) {
    return (
      <SafeAreaView style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#237453" />
        <Text style={styles.loadingText}>
          Loading your dashboard...
        </Text>
      </SafeAreaView>
    );
  }

  if (error) {
    return (
      <SafeAreaView style={styles.loadingContainer}>
        <Text style={styles.errorText}>{error}</Text>
      </SafeAreaView>
    );
  }

  const streak = calculateStreak();
  const checkedIn = hasCheckedInToday();

  return (
    <SafeAreaView style={styles.container}>
      <ScrollView
        showsVerticalScrollIndicator={false}
        contentContainerStyle={styles.scrollContent}
      >
        {/* Welcome Header */}
        <View style={styles.header}>
          <View>
            <Text style={styles.greeting}>
              {getGreeting()}, {user?.username || 'Friend'} 👋
            </Text>

            <Text style={styles.headerTitle}>
              Your journey, today.
            </Text>
          </View>

          <View style={styles.dateChip}>
            <Text style={styles.dateText}>{formattedDate}</Text>
          </View>
        </View>

        {/* Main Streak Card */}
        <View style={styles.streakCard}>
          <Text style={styles.cardLabel}>CURRENT STREAK</Text>

          <View style={[
            styles.statusBadge,
            checkedIn && styles.statusBadgeSuccess,
          ]}>
            <View style={[
              styles.statusDot,
              !checkedIn && styles.statusDotPending,
            ]} />

            <Text style={styles.statusText}>
              {checkedIn
                ? 'Checked in for today'
                : 'Your check-in is waiting'}
            </Text>
          </View>

          <View style={styles.streakRow}>
            <Text style={styles.streakNumber}>{streak}</Text>

            <Text style={styles.streakUnit}>
              day{streak === 1 ? '' : 's'} strong
            </Text>
          </View>

          <Text style={styles.streakMessage}>
            {checkedIn
              ? 'You showed up today. Keep protecting the momentum you have built.'
              : 'A small commitment today keeps your journey moving forward.'}
          </Text>

          
<TouchableOpacity
  style={[
    styles.checkinButton,
    checkedIn && styles.checkinButtonDone,
    checkingIn && { opacity: 0.7 },
  ]}
  disabled={checkedIn || checkingIn}
  activeOpacity={0.8}
  onPress={handleCheckin}
>

          
            <Text style={[
              styles.checkinButtonText,
              checkedIn && styles.checkinButtonTextDone,
            ]}>
              
{checkingIn
  ? 'Checking in...'
  : checkedIn
    ? '✓ Checked in today'
    : '✓  Check in today'}

            </Text>
          </TouchableOpacity>

{checkinMessage !== '' && (
  <Text style={styles.checkinFeedback}>
    {checkinMessage}
  </Text>
)}

        </View>

        {/* Progress Statistics */}
        <View style={styles.statsCard}>
          <Text style={styles.cardLabelDark}>YOUR PROGRESS</Text>

          <Text style={styles.statsHeading}>Every day counts.</Text>

          <View style={styles.statRow}>
            <View style={styles.statIcon}>
              <Text style={styles.statEmoji}>📅</Text>
            </View>

            <View style={styles.statCopy}>
              <Text style={styles.statLabel}>Total check-ins</Text>
              <Text style={styles.statDescription}>
                Days you showed up
              </Text>
            </View>

            <Text style={styles.statValue}>{checkins.length}</Text>
          </View>

          <View style={styles.statRow}>
            <View style={[styles.statIcon, styles.statIconGold]}>
              <Text style={styles.statEmoji}>🏆</Text>
            </View>

            <View style={styles.statCopy}>
              <Text style={styles.statLabel}>Best streak</Text>
              <Text style={styles.statDescription}>
                Your personal record
              </Text>
            </View>

            {/*  longest streak. */}
            <Text style={styles.statValue}>
  {calculateBestStreak()}
</Text>
          </View>
        </View>

        {/* Daily Motivation */}
        <View style={styles.motivationCard}>
          <View style={styles.quoteIcon}>
            <Text style={styles.quoteSymbol}>“</Text>
          </View>

          <View style={styles.motivationContent}>
            <Text style={styles.cardLabelDark}>A MOMENT FOR YOU</Text>

            <Text style={styles.motivationTitle}>
              Daily motivation
            </Text>

            <Text style={styles.quoteText}>
              “Small, faithful choices today create a stronger
              tomorrow.”
            </Text>
          </View>
        </View>

        {/* Achievements */}
        <TouchableOpacity
          style={styles.achievementCard}
          activeOpacity={0.85}
          onPress={() => {
            // Achievements screen will be connected later.
          }}
        >
          <View style={styles.achievementIcon}>
            <Text style={styles.achievementEmoji}>🏆</Text>
          </View>

          <View style={styles.achievementContent}>
            <Text style={styles.achievementTitle}>
              Achievements
            </Text>

            <Text style={styles.achievementDescription}>
              Celebrate every milestone and see how far
              you have come.
            </Text>
          </View>

          <Text style={styles.arrow}>→</Text>
        </TouchableOpacity>

        {/* Journey Tools */}
        <Text style={styles.sectionTitle}>Keep growing</Text>

        <View style={styles.toolCard}>
          <View style={[styles.toolIcon, styles.toolIconGreen]}>
            <Text style={styles.toolEmoji}>📝</Text>
          </View>

          <Text style={styles.toolTitle}>Journal</Text>
          <Text style={styles.toolDescription}>
            Make space to reflect honestly.
          </Text>
        </View>

        <View style={styles.toolCard}>
          <View style={[styles.toolIcon, styles.toolIconPurple]}>
            <Text style={styles.toolEmoji}>📖</Text>
          </View>

          <Text style={styles.toolTitle}>Motivation Center</Text>
          <Text style={styles.toolDescription}>
            Find strength, scripture, and support.
          </Text>
        </View>

        <View style={styles.toolCard}>
          <View style={[styles.toolIcon, styles.toolIconGold]}>
            <Text style={styles.toolEmoji}>🎯</Text>
          </View>

          <Text style={styles.toolTitle}>Goals & Rewards</Text>
          <Text style={styles.toolDescription}>
            Set your focus and track milestones.
          </Text>
        </View>

        {/* Footer */}
        <Text style={styles.footerText}>
          One day at a time. One choice at a time. 💚
        </Text>
      </ScrollView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F7FBF8',
  },

  loadingContainer: {
    flex: 1,
    backgroundColor: '#F7FBF8',
    justifyContent: 'center',
    alignItems: 'center',
  },

  loadingText: {
    marginTop: 15,
    color: '#174C38',
    fontSize: 15,
  },

  errorText: {
    color: '#B42318',
    fontSize: 16,
    textAlign: 'center',
    padding: 24,
  },

  scrollContent: {
    paddingHorizontal: 20,
    paddingTop: 20,
    paddingBottom: 40,
  },

  // Header
  header: {
    marginBottom: 25,
  },

  greeting: {
    fontSize: 14,
    fontWeight: '600',
    color: '#50645A',
  },

  headerTitle: {
    fontSize: 29,
    fontWeight: '800',
    color: '#10251D',
    letterSpacing: -0.8,
    marginTop: 5,
  },

  dateChip: {
    alignSelf: 'flex-start',
    backgroundColor: '#DFF8E9',
    paddingHorizontal: 12,
    paddingVertical: 9,
    borderRadius: 10,
    marginTop: 14,
  },

  dateText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#174C38',
  },

  // Main streak card
  streakCard: {
    backgroundColor: '#174C38',
    borderRadius: 24,
    padding: 25,
    overflow: 'hidden',
  },

  cardLabel: {
    color: 'rgba(255,255,255,0.7)',
    fontSize: 11,
    fontWeight: '800',
    letterSpacing: 1.5,
  },

  statusBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    alignSelf: 'flex-start',
    backgroundColor: 'rgba(255,255,255,0.11)',
    borderColor: 'rgba(255,255,255,0.17)',
    borderWidth: 1,
    borderRadius: 30,
    paddingHorizontal: 11,
    paddingVertical: 8,
    marginTop: 14,
  },

  statusBadgeSuccess: {
    backgroundColor: 'rgba(155,225,93,0.13)',
  },

  statusDot: {
    width: 8,
    height: 8,
    borderRadius: 4,
    backgroundColor: '#F8C65A',
    marginRight: 8,
  },

  statusDotPending: {
    backgroundColor: '#F8C65A',
  },

  statusText: {
    fontSize: 11,
    fontWeight: '700',
    color: '#FFFFFF',
  },

  streakRow: {
    flexDirection: 'row',
    alignItems: 'flex-end',
    marginTop: 22,
  },

  streakNumber: {
    fontSize: 86,
    fontWeight: '900',
    color: '#FFFFFF',
    letterSpacing: -5,
    lineHeight: 90,
  },

  streakUnit: {
    fontSize: 14,
    fontWeight: '700',
    color: 'rgba(255,255,255,0.8)',
    marginLeft: 10,
    marginBottom: 12,
  },

  streakMessage: {
    fontSize: 13,
    lineHeight: 20,
    color: 'rgba(255,255,255,0.78)',
    marginTop: 12,
    marginBottom: 22,
  },

  checkinButton: {
    backgroundColor: '#FFFFFF',
    borderRadius: 13,
    minHeight: 52,
    alignItems: 'center',
    justifyContent: 'center',
  },

  checkinButtonDone: {
    backgroundColor: 'rgba(255,255,255,0.14)',
    borderWidth: 1,
    borderColor: 'rgba(255,255,255,0.2)',
  },

  checkinButtonText: {
    color: '#174C38',
    fontSize: 14,
    fontWeight: '800',
  },

  checkinButtonTextDone: {
    color: 'rgba(255,255,255,0.8)',
  },

  // Statistics
  statsCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 22,
    borderWidth: 1,
    borderColor: 'rgba(23,76,56,0.10)',
    padding: 23,
    marginTop: 18,
  },

  cardLabelDark: {
    fontSize: 11,
    fontWeight: '800',
    letterSpacing: 1.3,
    color: '#50645A',
  },

  statsHeading: {
    fontSize: 21,
    fontWeight: '800',
    color: '#10251D',
    marginTop: 5,
    marginBottom: 15,
  },

  statRow: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 14,
    borderTopWidth: 1,
    borderTopColor: 'rgba(23,76,56,0.10)',
  },

  statIcon: {
    width: 42,
    height: 42,
    borderRadius: 13,
    backgroundColor: '#EDF8F0',
    justifyContent: 'center',
    alignItems: 'center',
  },

  statIconGold: {
    backgroundColor: '#FFF6DF',
  },

  statEmoji: {
    fontSize: 19,
  },

  statCopy: {
    flex: 1,
    marginLeft: 12,
  },

  statLabel: {
    fontSize: 12,
    fontWeight: '700',
    color: '#50645A',
  },

  statDescription: {
    fontSize: 11,
    color: '#809087',
    marginTop: 3,
  },

  statValue: {
    fontSize: 23,
    fontWeight: '900',
    color: '#174C38',
  },

  // Daily motivation
  motivationCard: {
    flexDirection: 'row',
    backgroundColor: '#FFFFFF',
    borderRadius: 22,
    borderWidth: 1,
    borderColor: 'rgba(23,76,56,0.10)',
    padding: 20,
    marginTop: 18,
  },

  quoteIcon: {
    width: 43,
    height: 43,
    borderRadius: 13,
    backgroundColor: '#DFF8E9',
    justifyContent: 'center',
    alignItems: 'center',
  },

  quoteSymbol: {
    fontSize: 30,
    fontWeight: '800',
    color: '#237453',
    marginTop: 6,
  },

  motivationContent: {
    flex: 1,
    marginLeft: 14,
  },

  motivationTitle: {
    fontSize: 16,
    fontWeight: '800',
    color: '#10251D',
    marginTop: 5,
    marginBottom: 8,
  },

  quoteText: {
    fontSize: 13,
    fontStyle: 'italic',
    lineHeight: 21,
    color: '#355145',
  },

  // Achievements
  achievementCard: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#60419D',
    borderRadius: 22,
    padding: 20,
    marginTop: 18,
  },

  achievementIcon: {
    width: 50,
    height: 50,
    borderRadius: 15,
    backgroundColor: 'rgba(255,255,255,0.16)',
    justifyContent: 'center',
    alignItems: 'center',
  },

  achievementEmoji: {
    fontSize: 25,
  },

  achievementContent: {
    flex: 1,
    marginLeft: 14,
  },

  achievementTitle: {
    fontSize: 16,
    fontWeight: '800',
    color: '#FFFFFF',
  },

  achievementDescription: {
    fontSize: 11,
    lineHeight: 17,
    color: 'rgba(255,255,255,0.8)',
    marginTop: 4,
  },

  arrow: {
    fontSize: 25,
    color: '#FFFFFF',
    marginLeft: 8,
  },

  // Journey tools
  sectionTitle: {
    fontSize: 20,
    fontWeight: '800',
    color: '#10251D',
    marginTop: 30,
    marginBottom: 14,
  },

  toolCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 18,
    borderWidth: 1,
    borderColor: 'rgba(23,76,56,0.10)',
    padding: 18,
    marginBottom: 12,
  },

  toolIcon: {
    width: 42,
    height: 42,
    borderRadius: 13,
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 13,
  },

  toolIconGreen: {
    backgroundColor: '#EEF8F1',
  },

  toolIconPurple: {
    backgroundColor: '#F0EDFF',
  },

  toolIconGold: {
    backgroundColor: '#FFF5DF',
  },

  toolEmoji: {
    fontSize: 20,
  },

  toolTitle: {
    fontSize: 15,
    fontWeight: '800',
    color: '#10251D',
  },

  toolDescription: {
    fontSize: 12,
    color: '#50645A',
    marginTop: 5,
    lineHeight: 18,
  },

  footerText: {
    fontSize: 12,
    color: '#809087',
    textAlign: 'center',
    marginTop: 22,
  },


checkinFeedback: {
  color: '#FFFFFF',
  fontSize: 12,
  fontWeight: '600',
  textAlign: 'center',
  marginTop: 12,
  lineHeight: 18,
},

});
