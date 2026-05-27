<script setup lang="ts">
import { Deferred } from "@inertiajs/vue3";
import type { Team } from "@/types";

defineProps<{
    teams?: Team[] | null;
}>();
</script>

<template>
    <div>
        <Deferred data="teams">
            <template #fallback>
                <div></div>
            </template>
            <div></div>
        </Deferred>
    </div>
</template>