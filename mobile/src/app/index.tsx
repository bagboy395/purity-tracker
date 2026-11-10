import { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  ActivityIndicator,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import * as SecureStore from 'expo-secure-store';
import { useRouter } from 'expo-router';

export default function LoginScreen() {
  const router = useRouter();
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');
  const [loading, setLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);

  const handleLogin = async () => {
    if (!username.trim() || !password) {
      setMessage('Please enter your username and password.');
      return;
    }

    setMessage('');
    setLoading(true);

    try {
      const response = await fetch(
        'http://172.20.10.3:8081/site/login',
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`,
        }
      );

      const data = await response.json();

     if (data.success) {
  await SecureStore.setItemAsync('userToken', data.token);
  router.replace('/dashboard');
} else {
        setMessage(data.message || 'Invalid username or password.');
      }
    } catch (error) {
      console.log('LOGIN ERROR:', error);
      setMessage('Could not connect to the server. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
        style={styles.keyboard}
      >
        <ScrollView
          contentContainerStyle={styles.container}
          keyboardShouldPersistTaps="handled"
        >
          <View style={styles.brand}>
            <View style={styles.logo}>
              <Text style={styles.logoText}>P</Text>
            </View>

            <Text style={styles.brandName}>Purity Tracker</Text>
            <Text style={styles.tagline}>
              Protect your peace. Build a stronger life.
            </Text>
          </View>

          <View style={styles.heading}>
            <Text style={styles.title}>Welcome back 👋</Text>
            <Text style={styles.subtitle}>
              Sign in to continue your journey.
            </Text>
          </View>

          <View style={styles.form}>
            <Text style={styles.label}>Username</Text>

            <TextInput
              style={styles.input}
              placeholder="Enter your username"
              placeholderTextColor="#94A399"
              value={username}
              onChangeText={setUsername}
              autoCapitalize="none"
              autoCorrect={false}
            />

            <Text style={styles.label}>Password</Text>

            <View style={styles.passwordContainer}>
              <TextInput
                style={styles.passwordInput}
                placeholder="Enter your password"
                placeholderTextColor="#94A399"
                value={password}
                onChangeText={setPassword}
                secureTextEntry={!showPassword}
                autoCapitalize="none"
              />

              <TouchableOpacity
                onPress={() => setShowPassword(!showPassword)}
              >
                <Text style={styles.showPassword}>
                  {showPassword ? 'Hide' : 'Show'}
                </Text>
              </TouchableOpacity>
            </View>

            <TouchableOpacity style={styles.forgotPassword}>
              <Text style={styles.forgotText}>Forgot password?</Text>
            </TouchableOpacity>

            <TouchableOpacity
              style={[
                styles.loginButton,
                loading && styles.loginButtonDisabled,
              ]}
              onPress={handleLogin}
              disabled={loading}
            >
              {loading ? (
                <ActivityIndicator color="#FFFFFF" />
              ) : (
                <Text style={styles.loginButtonText}>
                  Sign In  →
                </Text>
              )}
            </TouchableOpacity>

            {message !== '' && (
              <Text
                style={[
                  styles.message,
                  message.includes('successful')
                    ? styles.successMessage
                    : styles.errorMessage,
                ]}
              >
                {message}
              </Text>
            )}
          </View>

          <View style={styles.signupContainer}>
            <Text style={styles.signupText}>
              Don't have an account?{' '}
            </Text>

            <TouchableOpacity>
              <Text style={styles.signupLink}>Sign up</Text>
            </TouchableOpacity>
          </View>

          <Text style={styles.footer}>
            Every day is a new opportunity to grow. 🌱
          </Text>
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
  keyboard: {
    flex: 1,
  },
  container: {
    flexGrow: 1,
    paddingHorizontal: 26,
    paddingVertical: 30,
    justifyContent: 'center',
  },
  brand: {
    alignItems: 'center',
    marginBottom: 45,
  },
  logo: {
    width: 58,
    height: 58,
    backgroundColor: '#174C38',
    borderRadius: 18,
    borderBottomLeftRadius: 5,
    alignItems: 'center',
    justifyContent: 'center',
    transform: [{ rotate: '-5deg' }],
    marginBottom: 14,
  },
  logoText: {
    color: '#FFFFFF',
    fontSize: 32,
    fontWeight: '900',
  },
  brandName: {
    fontSize: 24,
    fontWeight: '800',
    color: '#10251D',
  },
  tagline: {
    fontSize: 12,
    color: '#718579',
    marginTop: 6,
    textAlign: 'center',
  },
  heading: {
    marginBottom: 28,
  },
  title: {
    fontSize: 27,
    fontWeight: '800',
    color: '#10251D',
  },
  subtitle: {
    fontSize: 15,
    color: '#718579',
    marginTop: 8,
  },
  form: {
    width: '100%',
  },
  label: {
    fontSize: 14,
    fontWeight: '700',
    color: '#244735',
    marginBottom: 9,
    marginTop: 18,
  },
  input: {
    height: 54,
    borderWidth: 1,
    borderColor: '#DCE8DF',
    borderRadius: 13,
    paddingHorizontal: 16,
    fontSize: 15,
    color: '#10251D',
    backgroundColor: '#FFFFFF',
  },
  passwordContainer: {
    height: 54,
    flexDirection: 'row',
    alignItems: 'center',
    borderWidth: 1,
    borderColor: '#DCE8DF',
    borderRadius: 13,
    paddingHorizontal: 16,
    backgroundColor: '#FFFFFF',
  },
  passwordInput: {
    flex: 1,
    fontSize: 15,
    color: '#10251D',
  },
  showPassword: {
    color: '#237453',
    fontWeight: '700',
    fontSize: 13,
    paddingLeft: 10,
  },
  forgotPassword: {
    alignSelf: 'flex-end',
    marginTop: 14,
  },
  forgotText: {
    fontSize: 13,
    color: '#237453',
    fontWeight: '700',
  },
  loginButton: {
    height: 56,
    backgroundColor: '#174C38',
    borderRadius: 13,
    alignItems: 'center',
    justifyContent: 'center',
    marginTop: 28,
  },
  loginButtonDisabled: {
    opacity: 0.7,
  },
  loginButtonText: {
    color: '#FFFFFF',
    fontSize: 16,
    fontWeight: '800',
  },
  message: {
    textAlign: 'center',
    marginTop: 15,
    fontSize: 14,
  },
  successMessage: {
    color: '#237453',
  },
  errorMessage: {
    color: '#C0392B',
  },
  signupContainer: {
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 28,
  },
  signupText: {
    fontSize: 14,
    color: '#718579',
  },
  signupLink: {
    fontSize: 14,
    color: '#237453',
    fontWeight: '800',
  },
  footer: {
    textAlign: 'center',
    fontSize: 12,
    color: '#94A399',
    marginTop: 38,
  },
});
