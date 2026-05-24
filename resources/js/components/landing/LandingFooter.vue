<script setup lang="ts">
const year = new Date().getFullYear();
</script>

<template>
    <footer class="border-border/60 border-t">
        <div
            class="text-muted-foreground mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-6 py-8 text-sm"
        >
            <p>© {{ year }} Peermitly</p>
            <nav class="flex items-center gap-5">
                <a class="hover:text-foreground transition-colors" href="#"
                    >Documentation</a
                >
                <a class="hover:text-foreground transition-colors" href="#"
                    >Status</a
                >
                <a class="hover:text-foreground transition-colors" href="#"
                    >Privacy</a
                >
            </nav>
        </div>
    </footer>
</template>
