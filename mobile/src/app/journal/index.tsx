
import { useCallback, useEffect, useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ActivityIndicator,
  FlatList,
  TouchableOpacity,
  RefreshControl,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import * as SecureStore from 'expo-secure-store';
import { useRouter } from 'expo-router';

const API_URL = 'http://172.20.10.3:8081';

type JournalEntry = {
  id: number;
  entry_date: string;
  temptation_type: string;
  intensity: number;
  what_happened: string;
  how_responded: string;
  notes: string | null;
};

export default function JournalScreen() {
  const router = useRouter();

  const [entries, setEntries] = useState<JournalEntry[]>([]);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [error, setError] = useState('');

  // Load the authenticated user's journal entries.
  const loadJournal = useCallback(async () => {
    try {
      setError('');

      // Retrieve the token saved during login.
      const token = await SecureStore.getItemAsync('userToken');

      if (!token) {
        setError('Your session has expired. Please log in again.');
        return;
      }

      // Request journal history from the Yii2 API.
      const response = await fetch(
        `${API_URL}/site/journals`,
        {
          method: 'GET',
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      const data = await response.json();

      if (!response.ok || !data.success) {
        setError(data.message || 'Could not load your journal entries.');
        return;
      }

      setEntries(
        Array.isArray(data.entries) ? data.entries : []
      );

    } catch (error) {
      console.log('JOURNAL ERROR:', error);
      setError('Could not connect to the server. Please try again.');
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  }, []);

  // Load journal history when the screen opens.
  useEffect(() => {
    loadJournal();
  }, [loadJournal]);

  // Refresh journal history.
  const handleRefresh = () => {
    setRefreshing(true);
    loadJournal();
  };

  // Format the database date for display.
  const formatDate = (date: string) => {
    const parsedDate = new Date(`${date}T00:00:00`);

    return parsedDate.toLocaleDateString('en-US', {
      month: 'long',
      day: 'numeric',
      year: 'numeric',
    });
  };

  // Display the appropriate intensity label.
  const getIntensityLabel = (intensity: number) => {
    if (intensity <= 3) return 'Low';
    if (intensity <= 6) return 'Moderate';
    return 'High';
  };

  // Render one journal entry.
  const renderEntry = ({ item }: { item: JournalEntry }) => (
    <View style={styles.entryCard}>
      <View style={styles.entryHeader}>
        <View style={styles.entryHeading}>
          <Text style={styles.entryType}>
            {item.temptation_type}
          </Text>

          <Text style={styles.entryDate}>
            {formatDate(item.entry_date)}
          </Text>
        </View>

        <View style={styles.intensityBadge}>
          <Text style={styles.intensityNumber}>
            {item.intensity}/10
          </Text>

          <Text style={styles.intensityLabel}>
            {getIntensityLabel(item.intensity)}
          </Text>
        </View>
      </View>

      <View style={styles.entryDivider} />

      <Text style={styles.fieldLabel}>WHAT HAPPENED</Text>

      <Text style={styles.entryText}>
        {item.what_happened}
      </Text>

      <Text style={styles.fieldLabel}>HOW I RESPONDED</Text>

      <Text style={styles.entryText}>
        {item.how_responded}
      </Text>

      {item.notes ? (
        <View style={styles.notesContainer}>
          <Text style={styles.fieldLabel}>PERSONAL NOTES</Text>

          <Text style={styles.notesText}>
            {item.notes}
          </Text>
        </View>
      ) : null}
    </View>
  );

  // Initial loading screen.
  if (loading) {
    return (
      <SafeAreaView style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#174C38" />

        <Text style={styles.loadingText}>
          Loading your journal...
        </Text>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <TouchableOpacity
          style={styles.backButton}
          onPress={() => router.back()}
        >
          <Text style={styles.backButtonText}>← Back</Text>
        </TouchableOpacity>

        <View style={styles.headerContent}>
          <Text style={styles.headerTitle}>My Journal</Text>

          <Text style={styles.headerDescription}>
            Your private space for reflection and growth.
          </Text>
        </View>
      </View>

      {/* Create a new journal entry. */}
      <View style={styles.createButtonContainer}>
        <TouchableOpacity
          style={styles.createButton}
          onPress={() => router.push('/journal/create')}
          activeOpacity={0.85}
        >
          <Text style={styles.createButtonText}>
            + New Journal Entry
          </Text>
        </TouchableOpacity>
      </View>

      <View style={styles.contentHeader}>
        <View>
          <Text style={styles.sectionTitle}>
            Your reflections
          </Text>

          <Text style={styles.sectionDescription}>
            {entries.length} {entries.length === 1 ? 'entry' : 'entries'} recorded
          </Text>
        </View>

        <TouchableOpacity
          style={styles.refreshButton}
          onPress={handleRefresh}
          disabled={refreshing}
        >
          <Text style={styles.refreshButtonText}>
            {refreshing ? 'Refreshing...' : '↻ Refresh'}
          </Text>
        </TouchableOpacity>
      </View>

      {error !== '' ? (
        <View style={styles.errorContainer}>
          <Text style={styles.errorText}>{error}</Text>

          <TouchableOpacity
            style={styles.retryButton}
            onPress={() => {
              setLoading(true);
              loadJournal();
            }}
          >
            <Text style={styles.retryButtonText}>
              Try again
            </Text>
          </TouchableOpacity>
        </View>
      ) : (
        <FlatList
          data={entries}
          keyExtractor={(item) => item.id.toString()}
          renderItem={renderEntry}
          contentContainerStyle={
            entries.length === 0
              ? styles.emptyList
              : styles.listContent
          }
          refreshControl={
            <RefreshControl
              refreshing={refreshing}
              onRefresh={handleRefresh}
              tintColor="#174C38"
            />
          }
          ListEmptyComponent={
            <View style={styles.emptyContainer}>
              <Text style={styles.emptyEmoji}>📝</Text>

              <Text style={styles.emptyTitle}>
                Your journal starts here.
              </Text>

              <Text style={styles.emptyDescription}>
                This is your space to reflect honestly,
                understand your experiences, and recognise
                your growth.
              </Text>

              <Text style={styles.emptyHint}>
                Your reflections will appear here.
              </Text>
            </View>
          }
        />
      )}

      <View style={styles.footer}>
        <Text style={styles.footerText}>
          Be honest with yourself. Growth begins with reflection. 💚
        </Text>
      </View>
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

  header: {
    paddingHorizontal: 20,
    paddingTop: 12,
    paddingBottom: 22,
  },

  backButton: {
    alignSelf: 'flex-start',
    paddingVertical: 8,
    paddingRight: 12,
    marginBottom: 15,
  },

  backButtonText: {
    color: '#174C38',
    fontSize: 14,
    fontWeight: '700',
  },

  headerContent: {
    gap: 6,
  },

  headerTitle: {
    color: '#10251D',
    fontSize: 29,
    fontWeight: '800',
    letterSpacing: -0.8,
  },

  headerDescription: {
    color: '#64756C',
    fontSize: 14,
    lineHeight: 21,
  },

  createButtonContainer: {
    paddingHorizontal: 20,
    marginBottom: 8,
  },

  createButton: {
    backgroundColor: '#174C38',
    paddingVertical: 15,
    borderRadius: 13,
    alignItems: 'center',
    justifyContent: 'center',
  },

  createButtonText: {
    color: '#FFFFFF',
    fontSize: 15,
    fontWeight: '700',
  },

  contentHeader: {
    paddingHorizontal: 20,
    paddingVertical: 15,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },

  sectionTitle: {
    color: '#10251D',
    fontSize: 18,
    fontWeight: '800',
  },

  sectionDescription: {
    color: '#75847C',
    fontSize: 12,
    marginTop: 4,
  },

  refreshButton: {
    backgroundColor: '#DFF8E9',
    paddingHorizontal: 13,
    paddingVertical: 9,
    borderRadius: 10,
  },

  refreshButtonText: {
    color: '#174C38',
    fontSize: 12,
    fontWeight: '700',
  },

  listContent: {
    paddingHorizontal: 20,
    paddingTop: 5,
    paddingBottom: 20,
  },

  entryCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 18,
    padding: 18,
    marginBottom: 15,
    borderWidth: 1,
    borderColor: '#E7EFE9',
  },

  entryHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    gap: 10,
  },

  entryHeading: {
    flex: 1,
  },

  entryType: {
    color: '#174C38',
    fontSize: 17,
    fontWeight: '800',
    textTransform: 'capitalize',
  },

  entryDate: {
    color: '#829087',
    fontSize: 12,
    marginTop: 5,
  },

  intensityBadge: {
    backgroundColor: '#EAF5ED',
    borderRadius: 12,
    paddingHorizontal: 12,
    paddingVertical: 9,
    alignItems: 'center',
  },

  intensityNumber: {
    color: '#174C38',
    fontSize: 15,
    fontWeight: '800',
  },

  intensityLabel: {
    color: '#648071',
    fontSize: 10,
    marginTop: 2,
  },

  entryDivider: {
    height: 1,
    backgroundColor: '#EAF0EC',
    marginVertical: 16,
  },

  fieldLabel: {
    color: '#829087',
    fontSize: 10,
    fontWeight: '800',
    letterSpacing: 1,
    marginBottom: 7,
    marginTop: 12,
  },

  entryText: {
    color: '#30443A',
    fontSize: 14,
    lineHeight: 22,
  },

  notesContainer: {
    backgroundColor: '#F5F9F6',
    borderRadius: 10,
    padding: 12,
    marginTop: 15,
  },

  notesText: {
    color: '#50645A',
    fontSize: 13,
    lineHeight: 20,
  },

  emptyList: {
    flexGrow: 1,
    justifyContent: 'center',
    paddingHorizontal: 30,
  },

  emptyContainer: {
    alignItems: 'center',
    paddingVertical: 35,
  },

  emptyEmoji: {
    fontSize: 45,
    marginBottom: 15,
  },

  emptyTitle: {
    color: '#174C38',
    fontSize: 20,
    fontWeight: '800',
    textAlign: 'center',
  },

  emptyDescription: {
    color: '#64756C',
    fontSize: 14,
    lineHeight: 22,
    textAlign: 'center',
    marginTop: 12,
  },

  emptyHint: {
    color: '#91A197',
    fontSize: 12,
    marginTop: 15,
  },

  errorContainer: {
    margin: 20,
    padding: 20,
    backgroundColor: '#FFF0EF',
    borderRadius: 15,
    alignItems: 'center',
  },

  errorText: {
    color: '#B42318',
    textAlign: 'center',
    fontSize: 14,
    lineHeight: 21,
  },

  retryButton: {
    backgroundColor: '#174C38',
    paddingHorizontal: 20,
    paddingVertical: 11,
    borderRadius: 10,
    marginTop: 15,
  },

  retryButtonText: {
    color: '#FFFFFF',
    fontWeight: '700',
  },

  footer: {
    paddingHorizontal: 20,
    paddingVertical: 15,
    alignItems: 'center',
  },

  footerText: {
    color: '#84948A',
    fontSize: 11,
    textAlign: 'center',
  },
});
