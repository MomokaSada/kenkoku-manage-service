<template>
    <div class="bg-slate-800 rounded-xl border-2 border-slate-600 flex flex-col h-[500px] w-full max-w-3xl shadow-2xl">
        <!-- Search Bar (Top) -->
        <div class="p-4 border-b border-slate-700 flex justify-between items-center bg-slate-900/50 rounded-t-xl">
            <h3 class="text-slate-300 font-minecraft font-bold">Select Item</h3>
            <div class="relative">
                <input 
                    v-model="search" 
                    @input="onSearch"
                    type="text" 
                    placeholder="Search items..." 
                    class="bg-black/50 border border-slate-600 text-white px-3 py-1 rounded text-sm w-64 focus:border-emerald-500 focus:outline-none placeholder-slate-500"
                >
                <svg class="h-4 w-4 text-slate-500 absolute right-2 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Inventory Grid -->
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar bg-[#C6C6C6] dark:bg-slate-700/50">
            <div v-if="loading" class="flex justify-center items-center h-full">
               <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-slate-800"></div>
            </div>
            
            <div v-else class="grid grid-cols-6 sm:grid-cols-9 gap-2">
                <div 
                    v-for="item in items" 
                    :key="item.id"
                    @click="selectItem(item)"
                    class="group relative bg-[#8B8B8B] dark:bg-slate-600 border-2 border-[#373737] hover:border-white w-10 h-10 flex items-center justify-center cursor-pointer transition-colors shadow-inner box-content"
                    :class="{'border-emerald-500': selectedId === item.id}"
                >
                    <!-- Icon Placeholder (Ideally use real item textures) -->
                     <span class="text-xl filter drop-shadow-md select-none group-hover:scale-110 transition-transform">
                        {{ getItemIcon(item.key) }}
                    </span>

                    <!-- Tooltip -->
                    <div class="absolute bottom-full mb-1 hidden group-hover:block z-50 whitespace-nowrap">
                         <div class="bg-[#100010] text-white text-xs px-2 py-1 rounded border-2 border-[#2a004e] shadow-xl relative -left-1/2">
                             <span class="text-[#5555FF] font-bold block">{{ item.name }}</span>
                             <span class="text-slate-400 font-mono text-[10px]">{{ item.key }}</span>
                         </div>
                    </div>
                </div>
            </div>
             <div v-if="!loading && items.length === 0" class="text-center text-slate-500 py-10">
                No items found.
            </div>
        </div>

        <!-- Pagination / Footer -->
        <div class="p-2 border-t border-slate-700 bg-slate-900/50 rounded-b-xl flex justify-between items-center text-xs text-slate-400">
             <span>{{ items.length }} items loaded</span>
             <button @click="$emit('cancel')" class="hover:text-white">Cancel</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue', 'select', 'cancel']);

const items = ref([]);
const loading = ref(false);
const search = ref('');
const selectedId = ref(props.modelValue);

// Debounce search
let timeout = null;
const onSearch = () => {
    clearTimeout(timeout);
    timeout = setTimeout(fetchItems, 300);
};

// Simple icon mapper based on key name
const getItemIcon = (key) => {
    if(key.includes('sword')) return '🗡️';
    if(key.includes('pickaxe')) return '⛏️';
    if(key.includes('axe')) return '🪓';
    if(key.includes('apple')) return '🍎';
    if(key.includes('bread')) return '🍞';
    if(key.includes('log') || key.includes('wood')) return '🪵';
    if(key.includes('stone')) return '🪨';
    if(key.includes('dirt') || key.includes('grass')) return '🌱';
    return '📦';
};

const fetchItems = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/items', {
            params: { search: search.value }
        });
        items.value = response.data;
    } catch (e) {
        console.error("Failed to fetch items", e);
    } finally {
        loading.value = false;
    }
};

const selectItem = (item) => {
    selectedId.value = item.id;
    emit('update:modelValue', item.id);
    emit('select', item);
};

onMounted(() => {
    fetchItems();
});
</script>

<style scoped>
/* Custom Scrollbar to match MC feel */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #2e2e2e;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 3px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #666;
}
</style>
