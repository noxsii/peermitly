<script setup lang="ts">
import PasswordCard from "@/components/settings/PasswordCard.vue";
import PageLayout from "@/layout/PageLayout.vue";
</script>

<template>
    <PageLayout title="Settings">
        <div class="grid max-w-3xl grid-cols-1 gap-4">
            <PasswordCard />
        </div>
    </PageLayout>
</template>
