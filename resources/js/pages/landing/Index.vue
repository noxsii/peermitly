<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import LandingCta from "@/components/landing/LandingCta.vue";
import LandingFeatures from "@/components/landing/LandingFeatures.vue";
import LandingFooter from "@/components/landing/LandingFooter.vue";
import LandingHero from "@/components/landing/LandingHero.vue";
import LandingNav from "@/components/landing/LandingNav.vue";

defineOptions({ layout: "" });
</script>

<template>
    <Head title="Permitlyy — License management" />

    <div class="bg-background text-foreground min-h-screen">
        <LandingNav />
        <main>
            <LandingHero />
            <LandingFeatures />
            <LandingCta />
        </main>
        <LandingFooter />
    </div>
</template>
