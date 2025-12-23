<template>
    <div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center p-4 font-mono text-white">
        <h1 class="text-6xl font-bold mb-4 text-red-500 pixel-font">404</h1>
        <p class="text-xl mb-8 pixel-font">Chunk Not Loaded</p>
        <p class="text-gray-400 mb-8 max-w-md text-center">
            The coordinates you are looking for do not exist in this world.
        </p>
        <router-link 
            to="/" 
            class="bg-gray-700 hover:bg-gray-600 border-2 border-gray-500 text-white font-bold py-3 px-6 rounded-none retro-btn transition duration-200"
        >
            Return to Spawn
        </router-link>
    </div>
</template>

<style scoped>
/* Placeholder for pixel font until imported globally */
.pixel-font {
    font-family: 'Courier New', Courier, monospace;
    letter-spacing: -1px;
}
.retro-btn {
    box-shadow: 4px 4px 0px 0px #000000;
}
.retro-btn:active {
    box-shadow: 2px 2px 0px 0px #000000;
    transform: translate(2px, 2px);
}
</style>
