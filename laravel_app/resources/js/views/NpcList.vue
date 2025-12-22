<template>
    <div class="flex h-screen bg-slate-900 font-sans text-slate-100 selection:bg-emerald-500 selection:text-white">
        <!-- Sidebar (Copied from Dashboard for consistency - Ideally should be a Layout) -->
        <aside class="w-64 bg-slate-800 border-r border-slate-700 flex flex-col">
            <div class="p-6 flex items-center space-x-3">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-white tracking-tight leading-none">MCDashboard</h1>
                    <span class="text-xs text-slate-400">Server Manager</span>
                </div>
            </div>

             <nav class="flex-1 px-4 space-y-2">
                <p class="px-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu</p>
                <router-link to="/dashboard" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition-colors">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </router-link>
                 <router-link to="/npcs" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 rounded-xl transition-colors">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    NPCs
                </router-link>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900 p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                     <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">NPC Management</h1>
                     <p class="text-slate-400">Create, edit, and manage your server's NPCs.</p>
                </div>
                <router-link to="/npcs/create" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded-xl shadow-lg shadow-emerald-500/20 transition-all flex items-center">
                     <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create NPC
                </router-link>
            </div>

            <!-- Filters -->
            <div class="bg-slate-800 p-4 rounded-2xl border border-slate-700/50 mb-6 flex space-x-4">
                <button @click="filter = 'all'" :class="{'bg-emerald-500 text-white': filter === 'all', 'text-slate-400 hover:text-white': filter !== 'all'}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors">All</button>
                <button @click="filter = '1'" :class="{'bg-blue-500 text-white': filter === '1', 'text-slate-400 hover:text-white': filter !== '1'}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors">Trades</button>
                <button @click="filter = '2'" :class="{'bg-purple-500 text-white': filter === '2', 'text-slate-400 hover:text-white': filter !== '2'}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors">Quests</button>
            </div>

            <!-- NPC Grid -->
            <div v-if="loading" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500 mx-auto"></div>
                <p class="text-slate-400 mt-4">Loading NPCs...</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <div v-for="npc in filteredNpcs" :key="npc.id" class="bg-slate-800 rounded-2xl border border-slate-700/50 overflow-hidden hover:shadow-xl hover:shadow-emerald-500/5 transition-all group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2 py-1 rounded text-xs font-bold" :class="getTypeClass(npc.npc_type_id)">
                                {{ getTypeLabel(npc.npc_type_id) }}
                            </span>
                             <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <router-link :to="`/npcs/${npc.id}/edit`" class="p-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-slate-300 hover:text-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </router-link>
                                <button @click="deleteNpc(npc.id)" class="p-1.5 bg-red-500/10 hover:bg-red-500 rounded-lg text-red-500 hover:text-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-slate-700 rounded-xl mx-auto mb-3 flex items-center justify-center text-4xl shadow-inner">
                                🧑‍🌾
                            </div>
                            <h3 class="text-xl font-bold text-white mb-1">{{ npc.name }}</h3>
                            <p class="text-sm text-slate-400">{{ npc.profession?.name || 'Vagrant' }}</p>
                        </div>
                        
                        <div class="space-y-2">
                             <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Biome</span>
                                <span class="text-slate-300">{{ npc.biome?.name || 'Unknown' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Level</span>
                                <span class="text-slate-300">Lv. {{ npc.level }}</span>
                            </div>
                             <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Trades</span>
                                <span class="text-emerald-400 font-bold">{{ npc.trades?.length || 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const npcs = ref([]);
const loading = ref(true);
const filter = ref('all');

// Helper to confirm Type ID mapping (Assuming 1=Trade, 2=Quest based on task context)
// In a real app, fetch types from API
const getTypeLabel = (id) => {
    switch(id) {
        case 1: return 'Trade';
        case 2: return 'Quest';
        case 3: return 'Other';
        default: return 'Unknown';
    }
};

const getTypeClass = (id) => {
    switch(id) {
        case 1: return 'bg-blue-500/20 text-blue-400 border border-blue-500/30';
        case 2: return 'bg-purple-500/20 text-purple-400 border border-purple-500/30';
        default: return 'bg-slate-700 text-slate-400';
    }
};

const filteredNpcs = computed(() => {
    if (filter.value === 'all') return npcs.value;
    return npcs.value.filter(n => n.npc_type_id == filter.value);
});

const fetchNpcs = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/npcs');
        npcs.value = response.data;
    } catch (e) {
        console.error("Failed to fetch NPCs", e);
    } finally {
        loading.value = false;
    }
};

const deleteNpc = async (id) => {
    if(!confirm("Are you sure you want to delete this NPC?")) return;
    try {
        await axios.post('/api/npcs', { delete: [id] });
        await fetchNpcs();
    } catch (e) {
        console.error("Failed to delete NPC", e);
        alert("Failed to delete NPC");
    }
};

onMounted(() => {
    fetchNpcs();
});
</script>
