<template>
    <div class="flex items-center justify-center min-h-screen bg-stone-900 pattern-dirt">
        <div class="w-full max-w-md bg-gray-800 border-4 border-gray-600 shadow-2xl p-8 relative">
            <!-- Minecraft-like Window Header -->
            <div class="absolute -top-10 left-0 w-full bg-gray-700 border-4 border-gray-600 border-b-0 h-10 flex items-center px-4">
                <span class="text-white font-mono font-bold pixel-font text-shadow">AUTHENTICATION</span>
            </div>

            <h2 class="text-3xl font-bold text-center text-white mb-8 pixel-font text-shadow-sm">Server Login</h2>
            
            <form @submit.prevent="handleLogin" class="space-y-6">
                <div>
                    <label class="block text-gray-300 text-sm font-bold mb-2 pixel-font" for="name">
                        USERNAME
                    </label>
                    <input 
                        v-model="form.name"
                        id="name" 
                        type="text" 
                        placeholder="Steve"
                        class="w-full px-4 py-3 bg-black border-2 border-gray-500 text-white placeholder-gray-600 focus:outline-none focus:border-green-500 font-mono"
                        required
                    />
                </div>
                
                <div>
                    <label class="block text-gray-300 text-sm font-bold mb-2 pixel-font" for="password">
                        PASSWORD
                    </label>
                    <input 
                        v-model="form.password"
                        id="password" 
                        type="password" 
                        placeholder="********"
                        class="w-full px-4 py-3 bg-black border-2 border-gray-500 text-white placeholder-gray-600 focus:outline-none focus:border-green-500 font-mono"
                        required
                    />
                </div>

                <div v-if="error" class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-2 text-sm pixel-font">
                    [!] {{ error }}
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-gray-500 hover:bg-gray-400 text-white font-bold py-4 px-4 border-b-4 border-gray-700 hover:border-gray-600 active:border-b-0 active:mt-1 active:mb-[-1px] transition-all pixel-font shadow-lg relative top-0"
                    :disabled="loading"
                >
                    {{ loading ? 'CONNECTING...' : 'JOIN SERVER' }}
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

.pixel-font {
    font-family: 'Press Start 2P', cursive;
    letter-spacing: -1px;
}
.text-shadow {
    text-shadow: 2px 2px 0px #000;
}
.text-shadow-sm {
    text-shadow: 1px 1px 0px #000;
}
.pattern-dirt {
    background-color: #1a1a1a;
    background-image: 
        linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111),
        linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111);
    background-size: 20px 20px;
    background-position: 0 0, 10px 10px;
}
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
