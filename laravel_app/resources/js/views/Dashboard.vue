<template>
    <div class="flex h-screen bg-[#1e1e1e] font-sans text-slate-100 selection:bg-emerald-500 selection:text-white">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#252526] border-r border-[#3e3e42] flex flex-col">
             <div class="p-4 flex items-center space-x-3 border-b border-[#3e3e42] bg-[#333333]">
                <div class="w-8 h-8 bg-emerald-600 rounded flex items-center justify-center font-bold text-lg">
                   M
                </div>
                <div>
                     <h1 class="text-base font-bold text-[#cccccc] tracking-tight leading-none">MCDashboard</h1>
                </div>
            </div>

            <!-- Simplified Nav -->
            <nav class="flex-1 p-2 space-y-1">
                <router-link to="/dashboard" class="flex items-center px-3 py-2 bg-[#37373d] text-white rounded transition-colors border-l-4 border-emerald-500">
                    <span class="mr-3">🏠</span>
                    Dashboard
                </router-link>
                 <router-link to="/npcs" class="flex items-center px-3 py-2 text-[#cccccc] hover:bg-[#2a2d2e] rounded transition-colors group">
                    <span class="mr-3 opacity-70 group-hover:opacity-100">⚙️</span>
                    NPCs
                </router-link>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#1e1e1e] p-8">
            <h1 class="text-3xl font-extrabold text-white mb-8 tracking-tight">Server Management</h1>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                
                <!-- Create NPC Card -->
                <router-link to="/npcs/create" class="bg-[#252526] p-6 rounded-xl border border-[#3e3e42] hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all group cursor-pointer flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-emerald-500/20 transition-colors">
                        <span class="text-3xl">➕</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Create New NPC</h3>
                    <p class="text-slate-400 text-sm">Add a new villager to the server with custom trades and professions.</p>
                </router-link>

                <!-- Manage NPCs Card -->
                <router-link to="/npcs" class="bg-[#252526] p-6 rounded-xl border border-[#3e3e42] hover:border-blue-500 hover:shadow-lg hover:shadow-blue-500/10 transition-all group cursor-pointer flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-500/20 transition-colors">
                        <span class="text-3xl">📋</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Manage NPCs</h3>
                    <p class="text-slate-400 text-sm">View, edit, or remove existing NPCs. Configure their locations and settings.</p>
                </router-link>

                <!-- Server Status (Simplified) -->
                <div class="bg-[#252526] p-6 rounded-xl border border-[#3e3e42] flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-yellow-500/10 rounded-full flex items-center justify-center mb-4">
                        <span class="text-3xl">📡</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">System Status</h3>
                    <div class="flex items-center space-x-2 text-emerald-400 font-bold bg-emerald-500/10 px-3 py-1 rounded-full text-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Online</span>
                    </div>
                </div>
            </div>

            <!-- Recent NPCs (Mini List) -->
            <div class="bg-[#252526] rounded-xl border border-[#3e3e42] overflow-hidden">
                <div class="p-4 border-b border-[#3e3e42] flex justify-between items-center bg-[#333333]">
                    <h3 class="font-bold text-white">Recently Added NPCs</h3>
                    <router-link to="/npcs" class="text-xs text-emerald-400 hover:text-emerald-300">View All</router-link>
                </div>
                
                <div v-if="loading" class="p-8 text-center text-slate-500">Loading...</div>
                <div v-else-if="npcs.length === 0" class="p-8 text-center text-slate-500">No NPCs found.</div>
                
                <div v-else class="divide-y divide-[#3e3e42]">
                    <div v-for="npc in npcs.slice(0, 5)" :key="npc.id" class="p-4 hover:bg-[#2a2d2e] transition-colors flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-[#3e3e42] rounded flex items-center justify-center text-xl">
                                🧑‍🌾
                            </div>
                            <div>
                                <div class="font-bold text-white">{{ npc.name }}</div>
                                <div class="text-xs text-slate-400">Lv. {{ npc.level }}</div>
                            </div>
                        </div>
                        <router-link :to="`/npcs/${npc.id}/edit`" class="text-xs bg-[#3e3e42] hover:bg-[#4e4e52] px-3 py-1 rounded text-white transition-colors">
                            Edit
                        </router-link>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const npcs = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const response = await axios.get('/api/npcs');
        // Sort by ID desc (newest first)
        npcs.value = response.data.sort((a, b) => b.id - a.id);
    } catch (e) {
        console.error("Failed to load NPCs", e);
    } finally {
        loading.value = false;
    }
});
</script>
