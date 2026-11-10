
import { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  StyleSheet,
  TouchableOpacity,
  ScrollView,
  ActivityIndicator,
  KeyboardAvoidingView,
  Platform,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useRouter } from 'expo-router';
import * as SecureStore from 'expo-secure-store';

const API_URL = 'http://172.20.10.3:8081';

const temptationTypes = [
  'Sexual thoughts',
  'Pornography',
  'Masturbation',
  'Social media',
  'Loneliness',
  'Stress',
  'Other',
];

export default function CreateJournalScreen() {
  const router = useRouter();

  const [temptationType, setTemptationType] = useState('');
  const [intensity, setIntensity] = useState(5);
  const [whatHappened, setWhatHappened] = useState('');
  const [howResponded, setHowResponded] = useState('');
  const [notes, setNotes] = useState('');

  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleSubmit = async () => {
    setError('');

    if (!temptationType || !whatHappened.trim() || !howResponded.trim()) {
      setError('Please complete all required fields.');
      return;
    }

    try {
      setLoading(true);

      const token = await SecureStore.getItemAsync('userToken');

      if (!token) {
        setError('Your session has expired. Please log in again.');
        return;
      }

      const response = await fetch(`${API_URL}/site/journals`, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          entry_date: new Date().toISOString().split('T')[0],
          temptation_type: temptationType,
          intensity,
          what_happened: whatHappened.trim(),
          how_responded: howResponded.trim(),
          notes: notes.trim(),
        }),
      });

      const data = await response.json();

      if (!response.ok || !data.success) {
        throw new Error(data.message || 'Unable to save your journal entry.');
      }

      router.replace('/journal/index');
    } catch (err) {
      setError(
        err instanceof Error
          ? err.message
          : 'Something went wrong. Please try again.'
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <KeyboardAvoidingView
        style={styles.container}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled"
          showsVerticalScrollIndicator={false}
        >
          <TouchableOpacity
            onPress={() => router.back()}
            style={styles.backButton}
          >
            <Text style={styles.backText}>← Back to Journal</Text>
          </TouchableOpacity>

          <Text style={styles.heading}>New Journal Entry</Text>

          <Text style={styles.subtitle}>
            Take a moment to reflect honestly. Every entry is an opportunity
            to understand yourself better.
          </Text>

          <Text style={styles.label}>Temptation Type *</Text>

          <View style={styles.optionsContainer}>
            {temptationTypes.map((type) => (
              <TouchableOpacity
                key={type}
                style={[
                  styles.option,
                  temptationType === type && styles.selectedOption,
                ]}
                onPress={() => setTemptationType(type)}
              >
                <Text
                  style={[
                    styles.optionText,
                    temptationType === type && styles.selectedOptionText,
                  ]}
                >
                  {type}
                </Text>
              </TouchableOpacity>
            ))}
          </View>

          <Text style={styles.label}>Intensity: {intensity}/10</Text>

          <View style={styles.intensityContainer}>
            {Array.from({ length: 10 }, (_, index) => index + 1).map(
              (number) => (
                <TouchableOpacity
                  key={number}
                  style={[
                    styles.intensityButton,
                    intensity === number && styles.selectedIntensity,
                  ]}
                  onPress={() => setIntensity(number)}
                >
                  <Text
                    style={[
                      styles.intensityText,
                      intensity === number && styles.selectedIntensityText,
                    ]}
                  >
                    {number}
                  </Text>
                </TouchableOpacity>
              )
            )}
          </View>

          <Text style={styles.label}>What happened? *</Text>
          <TextInput
            style={styles.textArea}
            placeholder="Describe what happened..."
            placeholderTextColor="#89968F"
            multiline
            textAlignVertical="top"
            value={whatHappened}
            onChangeText={setWhatHappened}
          />

          <Text style={styles.label}>How did you respond? *</Text>
          <TextInput
            style={styles.textArea}
            placeholder="Describe how you handled the situation..."
            placeholderTextColor="#89968F"
            multiline
            textAlignVertical="top"
            value={howResponded}
            onChangeText={setHowResponded}
          />

          <Text style={styles.label}>Additional Notes</Text>
          <TextInput
            style={styles.textArea}
            placeholder="Anything else you'd like to remember? (Optional)"
            placeholderTextColor="#89968F"
            multiline
            textAlignVertical="top"
            value={notes}
            onChangeText={setNotes}
          />

          {error ? <Text style={styles.errorText}>{error}</Text> : null}

          <TouchableOpacity
            style={[styles.submitButton, loading && styles.disabledButton]}
            onPress={handleSubmit}
            disabled={loading}
            activeOpacity={0.85}
          >
            {loading ? (
              <ActivityIndicator color="#FFFFFF" />
            ) : (
              <Text style={styles.submitText}>Save Journal Entry</Text>
            )}
          </TouchableOpacity>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#F7FBF8',
  },
  container: {
    flex: 1,
  },
  scrollContent: {
    padding: 22,
    paddingBottom: 45,
  },
  backButton: {
    marginBottom: 25,
  },
  backText: {
    color: '#174C38',
    fontSize: 15,
    fontWeight: '600',
  },
  heading: {
    fontSize: 27,
    fontWeight: 'bold',
    color: '#174C38',
    marginBottom: 9,
  },
  subtitle: {
    fontSize: 14,
    lineHeight: 22,
    color: '#718078',
    marginBottom: 28,
  },
  label: {
    fontSize: 15,
    fontWeight: '700',
    color: '#174C38',
    marginBottom: 12,
    marginTop: 20,
  },
  optionsContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 9,
  },
  option: {
    paddingVertical: 11,
    paddingHorizontal: 15,
    borderRadius: 12,
    backgroundColor: '#FFFFFF',
    borderWidth: 1,
    borderColor: '#E2EBE5',
  },
  selectedOption: {
    backgroundColor: '#174C38',
    borderColor: '#174C38',
  },
  optionText: {
    fontSize: 13,
    color: '#52645A',
    fontWeight: '500',
  },
  selectedOptionText: {
    color: '#FFFFFF',
  },
  intensityContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 8,
  },
  intensityButton: {
    width: 39,
    height: 42,
    borderRadius: 10,
    backgroundColor: '#FFFFFF',
    borderWidth: 1,
    borderColor: '#E2EBE5',
    alignItems: 'center',
    justifyContent: 'center',
  },
  selectedIntensity: {
    backgroundColor: '#174C38',
    borderColor: '#174C38',
  },
  intensityText: {
    color: '#52645A',
    fontWeight: '600',
  },
  selectedIntensityText: {
    color: '#FFFFFF',
  },
  textArea: {
    minHeight: 115,
    backgroundColor: '#FFFFFF',
    borderWidth: 1,
    borderColor: '#E2EBE5',
    borderRadius: 13,
    padding: 15,
    fontSize: 14,
    color: '#263A30',
    lineHeight: 21,
  },
  errorText: {
    color: '#C0392B',
    fontSize: 13,
    marginTop: 18,
  },
  submitButton: {
    backgroundColor: '#174C38',
    padding: 17,
    borderRadius: 14,
    alignItems: 'center',
    marginTop: 28,
  },
  disabledButton: {
    opacity: 0.65,
  },
  submitText: {
    color: '#FFFFFF',
    fontSize: 15,
    fontWeight: '700',
  },
});
