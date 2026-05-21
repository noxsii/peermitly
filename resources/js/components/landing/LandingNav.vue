<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
</script>

<template>
    <header
        class="border-border/60 bg-background/80 sticky top-0 z-30 w-full border-b backdrop-blur"
    >
        <div
            class="mx-auto flex h-16 max-w-6xl items-center justify-between px-6"
        >
            <Link
                :href="route('home')"
                class="text-foreground inline-flex items-center gap-2 text-base font-semibold tracking-tight"
            >
                <span
                    class="bg-primary text-primary-foreground inline-flex size-7 items-center justify-center rounded-lg text-xs font-bold"
                    aria-hidden="true"
                    >P</span
                >
                Permitlyy
            </Link>

            <Button as-child size="sm" variant="default">
                <Link :href="route('login')">Sign in</Link>
            </Button>
        </div>
    </header>
</template>
