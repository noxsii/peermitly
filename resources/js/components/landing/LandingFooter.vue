<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

const year = new Date().getFullYear();
</script>

<template>
    <footer class="border-border/60 border-t">
        <div
            class="text-muted-foreground mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-6 py-8 text-sm"
        >
            <p>© {{ year }} Peermitly</p>
            <nav class="flex items-center gap-5">
                <a
                    class="hover:text-foreground transition-colors"
                    href="https://peermitly.de/docs/api"
                    target="_blank"
                    rel="noopener noreferrer"
                    >Documentation</a
                >
                <a
                    class="hover:text-foreground transition-colors"
                    href="https://peermitly.betteruptime.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                    >Status</a
                >
                <Link
                    class="hover:text-foreground transition-colors"
                    :href="route('privacy')"
                >
                    Privacy
                </Link>
            </nav>
        </div>
    </footer>
</template>
