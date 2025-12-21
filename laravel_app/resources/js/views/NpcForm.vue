<template>
    <div class="flex h-screen bg-[#1e1e1e] font-sans text-slate-100 selection:bg-emerald-500 selection:text-white">
        <!-- Sidebar (Nav) -->
        <aside class="w-64 bg-[#252526] border-r border-[#3e3e42] flex flex-col">
             <div class="p-4 flex items-center space-x-3 border-b border-[#3e3e42] bg-[#333333]">
                <div class="w-8 h-8 bg-emerald-600 rounded flex items-center justify-center font-bold text-lg">
                   M
                </div>
                <div>
                     <h1 class="text-base font-bold text-[#cccccc] tracking-tight leading-none">MCDashboard</h1>
                </div>
            </div>
             <nav class="flex-1 p-2 space-y-1">
                <router-link to="/dashboard" class="flex items-center px-3 py-2 text-[#cccccc] hover:bg-[#2a2d2e] rounded transition-colors group">
                    <span class="mr-3 opacity-70 group-hover:opacity-100">🏠</span>
                    Dashboard
                </router-link>
                 <router-link to="/npcs" class="flex items-center px-3 py-2 bg-[#37373d] text-white rounded transition-colors border-l-4 border-emerald-500">
                    <span class="mr-3">⚙️</span>
                    NPCs
                </router-link>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden bg-[#1e1e1e] flex flex-col">
            <!-- Top Bar -->
            <div class="h-12 bg-[#252526] border-b border-[#3e3e42] flex items-center justify-between px-4">
                 <div class="flex items-center text-sm breadcrumbs text-[#cccccc]">
                    <router-link to="/npcs" class="hover:underline">NPCs</router-link>
                    <span class="mx-2 text-[#6e6e6e]">/</span>
                    <span class="text-white">{{ isEdit ? 'Edit ' + (form.name || 'NPC') : 'New NPC' }}</span>
                </div>
                <div class="space-x-2">
                     <router-link to="/npcs" class="px-3 py-1.5 text-xs bg-[#3e3e42] hover:bg-[#4e4e52] text-white rounded transition-colors">Cancel</router-link>
                     <button @click="save" :disabled="saving" class="px-3 py-1.5 text-xs bg-emerald-600 hover:bg-emerald-700 text-white rounded transition-colors font-bold flex items-center">
                        <span v-if="saving" class="animate-spin mr-1">⌛</span>
                        Save Changes
                     </button>
                </div>
            </div>

            <!-- Content Area (Mockup Layout) -->
            <div class="flex-1 overflow-auto p-8 flex justify-center">
                <div class="bg-[#f0f0f0] text-black w-full max-w-5xl shadow-2xl flex flex-col md:flex-row min-h-[600px] font-minecraft">
                    
                    <!-- Left Sidebar (Mockup Style) -->
                    <div class="w-full md:w-1/3 p-4 bg-[#f0f0f0] border-r-2 border-[#d9d9d9] flex flex-col space-y-4">
                        
                        <!-- Name Input (Added for functionality, though explicit in mockup header) -->
                         <div class="bg-[#c6c6c6] border-2 border-[#555555] p-1 flex items-center">
                            <span class="px-2 text-xs font-bold text-[#555] uppercase w-16">Name:</span>
                            <input v-model="form.name" type="text" class="flex-1 bg-transparent border-none focus:outline-none text-sm font-bold text-[#333] font-minecraft" placeholder="Villager Name">
                        </div>

                        <!-- Profession Selector -->
                        <div class="relative group">
                            <div class="bg-[#c6c6c6] border-2 border-b-0 border-[#555555] px-2 py-1 text-center font-bold text-sm text-[#333] shadow-inner select-none">
                                職業 (Profession)
                            </div>
                            <select v-model="form.profession_id" class="w-full bg-[#d9d9d9] border-2 border-[#555555] px-2 py-2 text-center text-sm font-bold focus:outline-none cursor-pointer appearance-none hover:bg-[#e6e6e6] transition-colors">
                                <option v-for="prof in professions" :key="prof.id" :value="prof.id">{{ prof.name || prof.key }}</option>
                            </select>
                            <div class="absolute right-3 bottom-3 pointer-events-none text-[#555]">▼</div>
                        </div>

                        <!-- Biome Selector -->
                        <div class="relative group">
                            <div class="bg-[#c6c6c6] border-2 border-b-0 border-[#555555] px-2 py-1 text-center font-bold text-sm text-[#333] shadow-inner select-none">
                                バイオーム (Biome)
                            </div>
                             <select v-model="form.biome_id" class="w-full bg-[#d9d9d9] border-2 border-[#555555] px-2 py-2 text-center text-sm font-bold focus:outline-none cursor-pointer appearance-none hover:bg-[#e6e6e6] transition-colors">
                                <option v-for="biome in biomes" :key="biome.id" :value="biome.id">{{ biome.name || biome.key }}</option>
                            </select>
                             <div class="absolute right-3 bottom-3 pointer-events-none text-[#555]">▼</div>
                        </div>

                         <!-- Entity Preview Area -->
                        <div class="flex-1 bg-[#d9d9d9] border-2 border-[#555555] shadow-inner flex flex-col items-center justify-center relative overflow-hidden min-h-[300px]">
                            <!-- Placeholder 3D Villager Image -->
                             <!-- Since we can't do real 3D easily, we use a high-quality static asset or emoji -->
                             <div class="relative z-10 transform scale-150">
                                 <!-- Fallback Visual -->
                                 <span class="text-9xl filter drop-shadow-xl">{{ getProfessionEmoji(form.profession_id) }}</span>
                             </div>
                             
                             <div class="absolute bottom-4 text-center z-10">
                                 <div class="font-bold text-lg text-[#333]">{{ form.name || 'Villager' }}</div>
                                 <div class="text-xs text-[#555] font-mono">{{ getBiomeName(form.biome_id) }}</div>
                             </div>

                             <!-- Grid Background -->
                             <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#555 1px, transparent 1px); background-size: 20px 20px;"></div>
                        </div>

                        <!-- Level Input -->
                         <div class="bg-[#c6c6c6] border-2 border-[#555555] p-2 flex items-center justify-between">
                            <span class="font-bold text-sm text-[#333]">Level:</span>
                             <input v-model="form.level" type="number" min="1" max="5" class="w-16 bg-[#d9d9d9] border border-[#555] text-center font-bold">
                        </div>
                    </div>

                    <!-- Right Main Area (Trade GUI) -->
                    <div class="w-full md:w-2/3 bg-[#c6c6c6] border-l-2 border-white flex flex-col p-4 relative">
                        <!-- Header & XP Bar -->
                        <div class="mb-6 text-center">
                            <h2 class="text-xl font-bold text-[#333] mb-2 font-minecraft">
                                {{ getProfessionName(form.profession_id) }} - {{ getLevelLabel(form.level) }}
                            </h2>
                            <!-- XP Bar -->
                            <div class="w-64 h-4 bg-[#8b8b8b] border-2 border-[#373737] mx-auto rounded-full overflow-hidden relative">
                                <div class="absolute inset-0 bg-[#000000] opacity-20"></div>
                                <div class="h-full bg-[#17d922] w-2/3 border-r-2 border-[#12ad1b] shadow-[inset_0_2px_0_rgba(255,255,255,0.3)]"></div>
                            </div>
                        </div>

                        <!-- Trade List Container -->
                        <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#c6c6c6] space-y-3 p-2 relative">
                             <!-- Loop Trades -->
                            <div v-if="form.trades.length === 0" class="text-center py-10 opacity-50 font-bold">
                                No Trades Configured
                            </div>

                             <McTradeRow 
                                v-for="(trade, index) in form.trades" 
                                :key="index" 
                                :trade="trade"
                                @edit-item="openItemSelector(index, 'input')" 
                                @add-reward="openItemSelector(index, 'reward-add')"
                                @edit-reward="(rIndex) => openItemSelector(index, 'reward-edit', rIndex)"
                                @remove-reward="(rIndex) => removeReward(index, rIndex)"
                                @remove="removeTrade(index)"
                            />

                             <!-- Add Button (Styled to fit) -->
                             <button @click="addTrade" class="w-full py-3 border-2 border-dashed border-[#777] hover:border-[#333] hover:bg-[#d9d9d9] text-[#555] hover:text-[#000] font-bold transition-colors flex items-center justify-center">
                                 + Add Trade
                             </button>
                        </div>
                        
                        <!-- Type Switcher (Hidden/Subtle) -->
                        <div class="absolute top-2 right-2 opacity-50 hover:opacity-100 transition-opacity">
                             <select v-model="form.npc_type_id" class="bg-[#c6c6c6] border border-[#555] text-xs px-1">
                                <option :value="1">Trade</option>
                                <option :value="2">Quest</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Item Selector Modal -->
            <div v-if="showSelector" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
                <ItemSelector 
                    v-model="selectorValue" 
                    @select="handleItemSelect"
                    @cancel="closeSelector" 
                />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import ItemSelector from './components/ItemSelector.vue';
import McTradeRow from './components/McTradeRow.vue';

const route = useRoute();
const router = useRouter();
const isEdit = computed(() => route.params.id !== undefined);
const saving = ref(false);

const biomes = ref([]);
const professions = ref([]);
const form = ref({
    name: 'Villager',
    npc_type_id: 1, 
    profession_id: 1,
    biome_id: 1,
    level: 1,
    trades: []
});

// Selector State
const showSelector = ref(false);
const selectorValue = ref(null);
const selectorContext = ref(null);

// Visual Helpers
const getProfessionEmoji = (id) => {
    const p = professions.value.find(p => p.id == id);
    if(p) {
        if(p.name?.includes('Farmer')) return '🌾';
        if(p.name?.includes('Librarian')) return '📚';
        if(p.name?.includes('Smith')) return '⚒️'; // Should cover Weapon, Tool
        if(p.name?.includes('Cleric')) return '⚗️';
    }
    return '🧑‍🌾';
};
const getProfessionName = (id) => {
    const p = professions.value.find(p => p.id == id);
    return p ? (p.name || p.key) : 'Unknown';
}
const getBiomeName = (id) => {
    const b = biomes.value.find(b => b.id == id);
    return b ? (b.name || b.key) : 'Plains';
}
const getLevelLabel = (lvl) => {
    const levels = ['Novice', 'Apprentice', 'Journeyman', 'Expert', 'Master'];
    return levels[(lvl - 1) % 5] || 'Novice';
}

// Logic (Same as before)
const addTrade = () => { form.value.trades.push({ item_id: null, quantity: 1, price: 0, rewards: [] }); };
const removeTrade = (index) => { form.value.trades.splice(index, 1); };
const removeReward = (tradeIndex, rIndex) => { form.value.trades[tradeIndex].rewards.splice(rIndex, 1); };

const openItemSelector = (tradeIndex, type, rewardIndex = null) => {
    selectorContext.value = { tradeIndex, type, rewardIndex };
    if (type === 'input') selectorValue.value = form.value.trades[tradeIndex].item_id;
    else if (type === 'reward-edit') selectorValue.value = form.value.trades[tradeIndex].rewards[rewardIndex].item_id;
    else selectorValue.value = null;
    showSelector.value = true;
};
const closeSelector = () => { showSelector.value = false; selectorContext.value = null; };
const handleItemSelect = (item) => {
    const { tradeIndex, type, rewardIndex } = selectorContext.value;
    if (type === 'input') form.value.trades[tradeIndex].item_id = item.id;
    else if (type === 'reward-add') form.value.trades[tradeIndex].rewards.push({ item_id: item.id, quantity: 1 });
    else if (type === 'reward-edit') form.value.trades[tradeIndex].rewards[rewardIndex].item_id = item.id;
    closeSelector();
};

const fetchMasterData = async () => {
    try {
        const [bRes, pRes] = await Promise.all([axios.get('/api/npcs/biomes'), axios.get('/api/npcs/professions')]);
        biomes.value = bRes.data;
        professions.value = pRes.data;
    } catch (e) {}
};
const fetchNpc = async (id) => {
    try {
        const response = await axios.get('/api/npcs');
        const npc = response.data.find(n => n.id == id);
        if (npc) {
            form.value = { ...npc };
            if(!form.value.trades) form.value.trades = [];
        }
    } catch (e) {}
};
const save = async () => {
    saving.value = true;
    try {
        const payload = isEdit.value ? { patch: [form.value] } : { store: [form.value] };
        await axios.post('/api/npcs', payload);
        router.push('/npcs');
    } catch (e) { alert("Failed to save"); } 
    finally { saving.value = false; }
};

onMounted(async () => {
    await fetchMasterData();
    if (isEdit.value) fetchNpc(route.params.id);
});
</script>

<style scoped>
/* Basic Font Face for Minecraft look */
@import url('https://fonts.googleapis.com/css2?family=VT323&display=swap');
.font-minecraft {
    font-family: 'VT323', monospace;
    letter-spacing: 0.5px;
}
.custom-scrollbar::-webkit-scrollbar { width: 8px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #c6c6c6; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #888; border: 2px solid #c6c6c6; }
</style>
