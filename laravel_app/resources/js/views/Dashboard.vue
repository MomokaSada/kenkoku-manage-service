<template>
    <div class="flex h-screen bg-stone-900 font-mono">
        <!-- MC Sidebar -->
        <aside class="w-64 bg-gray-800 border-r-4 border-gray-600 text-white flex flex-col">
            <div class="p-4 border-b-4 border-gray-600 bg-gray-700">
                <h1 class="text-xl font-bold pixel-font text-shadow text-yellow-400">SERVER ADMIN</h1>
                <p class="text-xs text-gray-400 mt-1">v1.21.1</p>
            </div>
            <nav class="flex-1 p-2 space-y-1">
                <a href="#" class="flex items-center px-4 py-3 bg-gray-700 border-2 border-white text-white shadow-sm mb-2 hover:bg-gray-600 transition-colors">
                    <span class="mr-3 text-lg">🧟</span>
                    <span class="pixel-font text-xs">NPC MANAGER</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 border-2 border-transparent text-gray-400 hover:text-white hover:bg-gray-700 hover:border-gray-500 transition-all">
                    <span class="mr-3 text-lg">⚙️</span>
                    <span class="pixel-font text-xs">SETTINGS</span>
                </a>
            </nav>
            <div class="p-4 border-t-4 border-gray-600 bg-gray-800">
                <button class="w-full py-2 bg-red-900 border-2 border-red-700 text-red-100 hover:bg-red-800 pixel-font text-xs">
                    DISCONNECT
                </button>
            </div>
        </aside>

        <!-- Main Content (Stone Background) -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-stone-800 pattern-stone p-8">
            <div class="border-4 border-gray-600 bg-gray-700/90 shadow-2xl p-6 min-h-full">
                <h3 class="text-white text-2xl mb-6 pixel-font text-shadow border-b-4 border-gray-500 pb-4 inline-block pr-8">
                    > NPC STATUS
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Stat Card -->
                    <div class="bg-gray-800 border-2 border-gray-500 p-4 shadow-lg flex items-center">
                        <div class="p-3 bg-green-900 border-2 border-green-700 text-green-100 mr-4">
                            API
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white pixel-font text-shadow">3</div>
                            <div class="text-gray-400 text-xs mt-1">Active Endpoints</div>
                        </div>
                    </div>
                </div>

                <div class="bg-black/30 border-2 border-gray-600 p-6">
                    <h4 class="text-gray-300 pixel-font mb-4 text-sm">[ CONFIGURATION TERMINAL ]</h4>
                    <div class="bg-black border border-gray-600 p-4 font-mono text-green-400 h-64 overflow-y-auto">
                        <p>> System initialized...</p>
                        <p>> Loading NPC data...</p>
                        <p class="animate-pulse">_</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

.pixel-font {
    font-family: 'Press Start 2P', cursive;
}
.text-shadow {
    text-shadow: 2px 2px 0px #000;
}
.pattern-stone {
    background-color: #292929;
    background-image: 
        radial-gradient(circle at 10% 20%, #333 1px, transparent 1.5px),
        radial-gradient(circle at 90% 80%, #333 1px, transparent 1.5px);
    background-size: 40px 40px;
}
</style>

<script setup>
// Dashboard logic
</script>
