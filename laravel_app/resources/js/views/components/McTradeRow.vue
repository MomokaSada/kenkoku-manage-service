<template>
    <div class="bg-[#c6c6c6] p-1 flex items-center justify-center w-full select-none h-[80px]">
        <!-- Container for the slots (mimicking the GUI row) -->
        <div class="flex items-center space-x-1">
            
            <!-- Input Slot 1 (Item) -->
            <div class="relative group">
                <div 
                    @click="$emit('edit-item', 'input1')"
                    class="w-[50px] h-[50px] bg-[#8b8b8b] border-2 border-r-white border-b-white border-t-[#373737] border-l-[#373737] flex items-center justify-center cursor-pointer hover:bg-[#999] transition-colors"
                >
                    <span v-if="trade.item_id" class="text-2xl filter drop-shadow-md">{{ getItemIcon(trade.item_id) }}</span>
                    <span v-if="trade.item_id" class="absolute bottom-1 right-1 text-white text-md font-bold font-minecraft drop-shadow-[0_2px_0_rgba(0,0,0,0.8)] leading-none">{{ trade.quantity }}</span>
                </div>
            </div>

            <!-- Input Slot 2 (Placeholder/Empty as per mockup) or Money -->
            <div class="relative group hidden md:block">
                 <div class="w-[50px] h-[50px] bg-[#8b8b8b] border-2 border-r-white border-b-white border-t-[#373737] border-l-[#373737] flex items-center justify-center opacity-50">
                    <!-- Placeholder for second input if ever needed -->
                </div>
            </div>

            <!-- Arrow -->
            <div class="px-2">
                 <!-- Minecraft specific arrow shape (SVG) -->
                <svg class="h-10 w-12 text-[#555] opacity-80" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                </svg>
            </div>

            <!-- Output Slot (Single Large Reward Slot look) -->
             <div class="relative group">
                <!-- If multiple rewards, we show first one mainly, or a + indicator? Mockup shows 1 big slot. -->
                <!-- We will make this the "Primary" reward slot. -->
                <div 
                    class="w-[60px] h-[60px] bg-[#8b8b8b] border-2 border-r-white border-b-white border-t-[#373737] border-l-[#373737] flex items-center justify-center cursor-pointer hover:bg-[#999] transition-colors relative"
                     @click="handleRewardClick"
                >
                    <span v-if="trade.rewards.length > 0" class="text-3xl filter drop-shadow-md">{{ getItemIcon(trade.rewards[0].item_id) }}</span>
                    <span v-if="trade.rewards.length > 0" class="absolute bottom-1 right-1 text-white text-lg font-bold font-minecraft drop-shadow-[0_2px_0_rgba(0,0,0,0.8)] leading-none">{{ trade.rewards[0].quantity }}</span>
                    
                     <!-- Multiple Rewards Indicator -->
                    <span v-if="trade.rewards.length > 1" class="absolute top-0 right-0 bg-emerald-500 text-white text-[10px] px-1 font-bold">+</span>
                </div>
            </div>

            <!-- Action Buttons (Subtle/Hidden usually) -->
            <div class="ml-4 flex flex-col space-y-1">
                 <button @click="$emit('add-reward')" class="text-xs text-[#555] hover:text-[#000] font-bold underline" title="Add secondary reward">More</button>
                 <button @click="$emit('remove')" class="text-xs text-red-800 hover:text-red-500 font-bold" title="Delete Row">X</button>
            </div>

        </div>
    </div>
</template>

<script setup>
const props = defineProps(['trade']);
const emit = defineEmits(['edit-item', 'add-reward', 'edit-reward', 'remove-reward', 'remove']);

const getItemIcon = (id) => {
    // Quick Hash for visuals
    const icons = ['🗡️', '⛏️', '🪓', '🍎', '🍞', '🪵', '🪨', '💎', '🍖', '🏹', '🧪', '🧟', '🦴', '🕷️', '📜'];
    return icons[(id || 0) % icons.length] || '';
};

const handleRewardClick = () => {
    if (props.trade.rewards.length > 0) {
        emit('edit-reward', 0);
    } else {
        emit('add-reward');
    }
};
</script>

<style scoped>
.font-minecraft {
    font-family: 'VT323', monospace;
}
</style>
