<template>
    <div class="flex h-screen bg-[#111316] font-sans text-slate-100 selection:bg-emerald-500 selection:text-white">
        <!-- Sidebar (Villager OS Style) -->
        <aside class="w-64 bg-[#111316] border-r border-[#1f2128] flex flex-col">
            <div class="p-6 flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-emerald-500 rounded flex items-center justify-center font-bold text-lg text-white">
                    V
                </div>
                <h1 class="text-xl font-bold text-white tracking-tight">VILLAGER OS</h1>
            </div>

            <nav class="flex-1 px-4 space-y-2">
                <a href="#" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-[#1f2128] rounded-xl transition-colors">
                    <span class="mr-3">🥡</span> Entities
                </a>
                <a href="#" class="flex items-center px-4 py-3 bg-[#1f2128] text-emerald-400 border-l-2 border-emerald-500 rounded-r-xl transition-colors">
                    <span class="mr-3">⚙️</span> Configuration
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-[#1f2128] rounded-xl transition-colors">
                    <span class="mr-3">📊</span> Market Analytics
                </a>
            </nav>

            <!-- Server Status Bottom -->
            <div class="p-4 mt-auto">
                <div class="bg-[#1f2128] rounded-xl p-4 border border-[#2d3039]">
                    <div class="text-xs font-bold text-slate-500 uppercase mb-2">Status</div>
                    <div class="flex items-center text-sm font-bold text-white">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                        Server Connected
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden flex flex-col relative">
             <!-- Header -->
             <header class="h-16 border-b border-[#1f2128] flex items-center justify-between px-8 bg-[#111316]">
                <div class="flex items-center">
                    <h2 class="text-2xl font-bold text-white mr-4">Villager Editor</h2>
                    <div class="bg-[#1f2128] px-3 py-1 rounded text-xs text-slate-400 font-mono">
                         UUID: {{ uuid || 'generating...' }}
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button @click="router.push('/npcs')" class="text-slate-400 hover:text-white font-bold text-sm transition-colors">Cancel</button>
                    <!-- <button class="text-slate-400 hover:text-white font-bold text-sm transition-colors">Export NBT</button> -->
                    <button @click="save" :disabled="saving" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-emerald-500/20 transition-all flex items-center">
                        <span v-if="saving" class="animate-spin mr-2">⌛</span>
                        {{ isEdit ? 'Apply Changes' : 'Create Entity' }}
                    </button>
                </div>
             </header>

             <!-- Content Body -->
             <div class="flex-1 overflow-auto p-8 flex gap-8">
                 
                 <!-- Left Column: Attributes & Preview -->
                 <div class="w-1/3 flex flex-col gap-6">
                     
                     <!-- Preview Card -->
                     <div class="bg-[#181a20] rounded-2xl p-6 border border-[#2d3039] flex flex-col items-center relative group">
                        <!-- Status Badges -->
                        <div class="absolute top-4 left-4 flex space-x-2">
                             <span class="bg-emerald-500/20 text-emerald-400 text-xs font-bold px-2 py-1 rounded border border-emerald-500/30">ALIVE</span>
                             <span class="bg-blue-500/20 text-blue-400 text-xs font-bold px-2 py-1 rounded border border-blue-500/30">IDLE</span>
                        </div>

                        <!-- 3D Preview Placeholder -->
                        <div class="h-64 w-full flex items-center justify-center relative my-4">
                             <!-- Glowing Backdrop -->
                            <div class="absolute inset-0 bg-emerald-500/5 blur-3xl rounded-full transform scale-75"></div>
                            
                            <!-- Emoji / Image -->
                            <div class="relative z-10 transform transition-transform duration-500 group-hover:scale-110 cursor-pointer">
                                <span class="text-9xl filter drop-shadow-2xl">{{ getProfessionEmoji(form.profession_id) }}</span>
                            </div>

                            <!-- Controls -->
                            <div class="absolute bottom-0 right-0 flex space-x-2">
                                <button class="p-2 bg-[#1f2128] rounded-lg text-slate-400 hover:text-white border border-[#2d3039]">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                </button>
                                <button class="p-2 bg-[#1f2128] rounded-lg text-slate-400 hover:text-white border border-[#2d3039]">
                                   <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" /></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Labels -->
                        <div class="text-center mt-2">
                            <h3 class="text-xl font-bold text-white">{{ form.name || 'Villager' }}</h3>
                            <p class="text-slate-500 italic">Level {{ form.level }}: {{ getLevelLabel(form.level) }} {{ getProfessionName(form.profession_id) }}</p>
                        </div>
                     </div>

                     <!-- Base Attributes -->
                     <div class="bg-[#181a20] rounded-2xl p-6 border border-[#2d3039]">
                         <h4 class="text-xs font-bold text-slate-500 uppercase mb-4 tracking-wider">Base Attributes</h4>
                         
                         <div class="space-y-4">
                             <div>
                                 <label class="block text-xs font-bold text-slate-400 mb-1">NAME TAG</label>
                                 <input v-model="form.name" type="text" class="w-full bg-[#111316] border border-[#2d3039] rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500 transition-colors" placeholder="e.g. Gennaro">
                             </div>

                             <div>
                                 <label class="block text-xs font-bold text-slate-400 mb-1">PROFESSION</label>
                                 <div class="relative">
                                    <select v-model="form.profession_id" class="w-full bg-[#111316] border border-[#2d3039] rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500 transition-colors appearance-none cursor-pointer">
                                        <option v-for="prof in professions" :key="prof.id" :value="prof.id">{{ prof.name || prof.key }}</option>
                                    </select>
                                    <div class="absolute right-3 top-3 pointer-events-none text-slate-500">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                 </div>
                             </div>

                              <div>
                                 <label class="block text-xs font-bold text-slate-400 mb-1">BIOME TYPE</label>
                                 <div class="relative">
                                    <select v-model="form.biome_id" class="w-full bg-[#111316] border border-[#2d3039] rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500 transition-colors appearance-none cursor-pointer">
                                        <option v-for="biome in biomes" :key="biome.id" :value="biome.id">{{ biome.name || biome.key }}</option>
                                    </select>
                                    <div class="absolute right-3 top-3 pointer-events-none text-slate-500">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                 </div>
                             </div>
                             
                             <div class="flex items-center justify-between pt-2">
                                 <div>
                                     <div class="text-sm font-bold text-white">Silent Mode</div>
                                     <div class="text-xs text-slate-500">Disables ambient sounds</div>
                                 </div>
                                 <Toggle v-model="form.is_silent" /> <!-- Using component -->
                             </div>
                         </div>
                     </div>
                 </div>

                 <!-- Right Column: Trade Offers -->
                 <div class="w-2/3 bg-[#181a20] rounded-2xl p-8 border border-[#2d3039] flex flex-col">
                     <div class="flex justify-between items-start mb-8">
                         <div>
                             <h3 class="text-lg font-bold text-white mb-1">TRADE OFFERS</h3>
                             <p class="text-slate-500 text-sm">Configure item exchange rules for this entity.</p>
                         </div>
                         <button @click="addTrade" class="bg-[#1f2128] hover:bg-[#2d3039] text-emerald-400 border border-emerald-500/30 text-xs font-bold py-2 px-4 rounded-lg transition-colors flex items-center">
                             <span class="mr-2 text-lg leading-none">+</span> ADD NEW TRADE
                         </button>
                     </div>

                     <!-- Trades List -->
                     <div class="space-y-4 flex-1 overflow-y-auto custom-scrollbar pr-2">
                         <div v-for="(trade, index) in form.trades" :key="index" class="bg-[#111316] border border-[#2d3039] rounded-xl p-4 flex items-center justify-between group hover:border-emerald-500/30 transition-colors">
                             
                             <div class="flex items-center gap-4 flex-1">
                                 <!-- Input A -->
                                 <div class="flex flex-col items-center">
                                      <div @click="openItemSelector(index, 'input')" class="w-16 h-16 bg-[#1f2128] rounded-lg border border-[#2d3039] flex items-center justify-center cursor-pointer hover:border-emerald-500 transition-colors relative group/slot overflow-hidden">
                                          <span v-if="!trade.item_id" class="text-2xl opacity-20">⬜</span>
                                          <img v-else :src="getWikiItemImage(getItemKey(trade.item))" class="w-10 h-10 object-contain pixelated transition-transform hover:scale-125" onerror="this.innerText='📦'">
                                          
                                          <!-- Quantity Badge -->
                                          <div class="absolute bottom-1 right-1 bg-[#111316] text-white text-[10px] font-bold px-1.5 rounded border border-[#2d3039]">
                                              {{ trade.quantity || 1 }}
                                          </div>
                                      </div>
                                      <span class="text-[10px] font-bold text-slate-500 mt-2 uppercase tracking-wide">Input A</span>
                                 </div>

                                 <span class="text-slate-600 text-lg">+</span>

                                 <!-- Input B (Empty for now) -->
                                 <div class="flex flex-col items-center opacity-50">
                                      <div class="w-16 h-16 bg-[#1f2128]/50 rounded-lg border border-[#2d3039] border-dashed flex items-center justify-center">
                                          <span class="text-2xl opacity-10">⬜</span>
                                      </div>
                                      <span class="text-[10px] font-bold text-slate-600 mt-2 uppercase tracking-wide">Input B</span>
                                 </div>

                                 <!-- Arrow -->
                                 <div class="flex flex-col items-center px-4">
                                     <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                     <span class="text-[10px] font-bold text-slate-600 mt-1 uppercase tracking-wide">Exchange</span>
                                 </div>

                                  <!-- Output (Reward) -->
                                 <div class="flex flex-col items-center">
                                      <div @click="openItemSelector(index, 'reward-edit', 0)" class="w-16 h-16 bg-[#1f2128] rounded-lg border border-emerald-500/30 flex items-center justify-center cursor-pointer hover:bg-emerald-500/10 transition-colors relative overflow-hidden">
                                          <span v-if="!trade.rewards?.[0]?.item_id" class="text-2xl opacity-20">🎁</span>
                                           <template v-else>
                                                <!-- Reward Item Image -->
                                                <img :src="getWikiItemImage(getItemKey(trade.rewards[0].item))" class="w-10 h-10 object-contain pixelated transition-transform hover:scale-125" onerror="this.style.display='none'">
                                           </template>

                                          <!-- Quantity Badge -->
                                          <div v-if="trade.rewards?.[0]" class="absolute bottom-1 right-1 bg-[#111316] text-emerald-400 text-[10px] font-bold px-1.5 rounded border border-emerald-500/30">
                                              {{ trade.rewards[0].quantity || 1 }}
                                          </div>
                                      </div>
                                      <span class="text-[10px] font-bold text-emerald-500 mt-2 uppercase tracking-wide">Output</span>
                                 </div>
                             </div>

                             <!-- Actions -->
                             <div class="flex flex-col gap-2 ml-4">
                                 <button class="p-2 rounded-lg bg-[#1f2128] text-slate-400 hover:text-white border border-[#2d3039] transition-colors">
                                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                 </button>
                                 <button @click="removeTrade(index)" class="p-2 rounded-lg bg-[#1f2128] text-slate-400 hover:text-red-500 hover:bg-red-500/10 border border-[#2d3039] transition-colors">
                                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                 </button>
                             </div>

                         </div>
                         
                         <!-- Add Trade Ghost -->
                         <div @click="addTrade" class="border-2 border-dashed border-[#2d3039] rounded-xl p-8 flex flex-col items-center justify-center cursor-pointer hover:border-emerald-500/50 hover:bg-emerald-500/5 transition-all group">
                             <div class="text-4xl text-slate-600 mb-2 group-hover:text-emerald-500 transition-colors">+</div>
                             <div class="text-sm font-bold text-slate-500 group-hover:text-emerald-400 transition-colors">More trades can be defined.</div>
                             <div class="text-xs text-slate-600">Villager trade limit: 10 active offers.</div>
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Item Selector Modal Over -->
            <div v-if="showSelector" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
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
import Toggle from './components/Toggle.vue';

const route = useRoute();
const router = useRouter();
const isEdit = computed(() => route.params.id !== undefined);
const saving = ref(false);
const uuid = ref('550e8400-e29b-41d4-a716-446655440000'); 

const biomes = ref([]);
const professions = ref([]);
const form = ref({
    name: 'Gennaro',
    npc_type_id: 1, 
    profession_id: 2, 
    biome_id: 1,     
    level: 5,
    is_silent: false,
    trades: []
});

// Selector State
const showSelector = ref(false);
const selectorValue = ref(null);
const selectorContext = ref(null);

// Item Image Cache
const itemImageCache = ref(new Map());

// Visual Helpers
const getProfessionEmoji = (id) => {
    const p = professions.value.find(p => p.id == id);
    if(p) {
        if(p.name?.includes('Farmer')) return '🌾';
        if(p.name?.includes('Librarian')) return '📚';
        if(p.name?.includes('Smith')) return '⚒️'; 
        if(p.name?.includes('Cleric')) return '⚗️';
    }
    return '🧑‍🌾'; 
};
const getProfessionName = (id) => {
    const p = professions.value.find(p => p.id == id);
    return p ? (p.name || p.key) : 'Unknown';
}
const getLevelLabel = (lvl) => {
    const levels = ['Novice', 'Apprentice', 'Journeyman', 'Expert', 'Master'];
    return levels[(lvl - 1) % 5] || 'Novice';
}

const getItemKey = (item) => {
    return item?.key || null;
}

const getWikiItemImage = (itemKey) => {
    if (!itemKey) return null;
    
    // Normalize format: minecraft:iron_ingot -> Iron_Ingot
    // 1. Remove namespace 'minecraft:'
    // 2. Split by '_' and capitalize each word
    // 3. Join with '_'
    
    // Check cache
    if (itemImageCache.value.has(itemKey)) {
        return itemImageCache.value.get(itemKey);
    }

    // Set placeholder initially to avoid re-fetching
    itemImageCache.value.set(itemKey, null); 

    const cleanKey = itemKey.replace(/^minecraft:/, '');
    const formatted = cleanKey.split('_')
        .map(w => w.charAt(0).toUpperCase() + w.slice(1))
        .join('_');
        
    const filename = `File:${formatted}.png`;
    const url = `https://minecraft.wiki/api.php?action=query&titles=${filename}&prop=imageinfo&iiprop=url&format=json&origin=*`;

    axios.get(url).then(res => {
        const pages = res.data.query?.pages;
        if (pages) {
             const pageId = Object.keys(pages)[0];
             if (pageId != -1) {
                 const imgUrl = pages[pageId]?.imageinfo?.[0]?.url;
                 if (imgUrl) {
                     itemImageCache.value.set(itemKey, imgUrl);
                 }
             }
        }
    }).catch(console.error);
    
    return null; // Return null initially, vue reactive map will update view when axios finishes
};

// Logic
const addTrade = () => { 
    form.value.trades.push({ 
        item_id: null, 
        quantity: 1, 
        price: 0, 
        rewards: [{ item_id: null, quantity: 1 }]
    }); 
};
const removeTrade = (index) => { form.value.trades.splice(index, 1); };

const openItemSelector = (tradeIndex, type, rewardIndex = null) => {
    selectorContext.value = { tradeIndex, type, rewardIndex };
    if (type === 'input') {
        selectorValue.value = form.value.trades[tradeIndex].item_id;
    }
    else if (type === 'reward-edit') {
         if(!form.value.trades[tradeIndex].rewards) form.value.trades[tradeIndex].rewards = [];
         if(!form.value.trades[tradeIndex].rewards[rewardIndex]) form.value.trades[tradeIndex].rewards[rewardIndex] = { item_id: null, quantity: 1 };
         
        selectorValue.value = form.value.trades[tradeIndex].rewards[rewardIndex].item_id;
    }
    showSelector.value = true;
};

const closeSelector = () => { showSelector.value = false; selectorContext.value = null; };

const handleItemSelect = (item) => {
    const { tradeIndex, type, rewardIndex } = selectorContext.value;
    if (type === 'input') {
        form.value.trades[tradeIndex].item_id = item.id;
        form.value.trades[tradeIndex].item = item; // Store item object for key access
    }
    else if (type === 'reward-edit') {
         if(!form.value.trades[tradeIndex].rewards) form.value.trades[tradeIndex].rewards = [];
         if (!form.value.trades[tradeIndex].rewards[rewardIndex]) {
             form.value.trades[tradeIndex].rewards[rewardIndex] = { quantity: 1 };
         }
         form.value.trades[tradeIndex].rewards[rewardIndex].item_id = item.id;
         form.value.trades[tradeIndex].rewards[rewardIndex].item = item; // Store item object
    }
    closeSelector();
};

const fetchMasterData = async () => {
    try {
        const [bRes, pRes] = await Promise.all([axios.get('/api/npcs/biomes'), axios.get('/api/npcs/professions')]);
        biomes.value = bRes.data;
        professions.value = pRes.data;
    } catch (e) { console.error(e) }
};
const fetchNpc = async (id) => {
    try {
        const response = await axios.get('/api/npcs');
        const npc = response.data.find(n => n.id == id);
        if (npc) {
            form.value = { ...npc };
            if(!form.value.trades) form.value.trades = [];
            form.value.trades.forEach(t => {
                if(!t.rewards) t.rewards = [{ item_id: null, quantity: 1 }];
            });
            uuid.value = npc.uuid || '550e8400-e29b-41d4-a716-' + Math.floor(Math.random() * 10000);
        }
    } catch (e) { console.error(e) }
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
    else uuid.value = 'Generated on Save';
});
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #2d3039; border-radius: 3px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3e424e; }

.pixelated {
    image-rendering: pixelated;
}
</style>
