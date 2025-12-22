<template>
    <div class="flex items-center justify-center min-h-screen bg-slate-900 font-sans">
        <div class="w-full max-w-md p-8 bg-slate-800 rounded-2xl shadow-xl">
            <div class="flex flex-col items-center mb-8">
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white tracking-tight">MCDashboard</h2>
                <p class="text-slate-400 text-sm mt-1">Manage your Minecraft Server</p>
            </div>
            
            <form @submit.prevent="handleLogin" class="space-y-6">
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-2" for="name">
                        Username
                    </label>
                    <input 
                        v-model="form.name"
                        id="name" 
                        type="text" 
                        placeholder="Admin"
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition duration-200"
                        required
                    />
                </div>
                
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-2" for="password">
                        Password
                    </label>
                    <input 
                        v-model="form.password"
                        id="password" 
                        type="password" 
                        placeholder="••••••••"
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition duration-200"
                        required
                    />
                </div>

                <div v-if="error" class="bg-red-500/10 border border-red-500/50 text-red-500 px-4 py-3 rounded-xl text-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ error }}
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-emerald-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-emerald-500 transition-all duration-200 transform hover:-translate-y-0.5"
                    :disabled="loading"
                >
                    <span v-if="loading" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Connecting...
                    </span>
                    <span v-else>Login to Dashboard</span>
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* No custom styles needed, using utility classes */
</style>

<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const form = reactive({
    name: '',
    password: ''
});
const error = ref('');
const loading = ref(false);

const handleLogin = async () => {
    loading.value = true;
    error.value = '';

    try {
        const response = await axios.post('/api/auth/login', form);
        
        const token = response.data.token;
        if (token) {
            localStorage.setItem('auth_token', token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            router.push('/dashboard');
        } else {
             error.value = 'Login failed: No token received';
        }

    } catch (err) {
        if (err.response && err.response.data && err.response.data.message) {
            error.value = err.response.data.message;
        } else {
            error.value = 'An error occurred during login.';
        }
        console.error(err);
    } finally {
        loading.value = false;
    }
};
</script>
