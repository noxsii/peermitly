<script setup lang="ts">
import ApiTokensCard from "@/components/settings/ApiTokensCard.vue";
import PasswordCard from "@/components/settings/PasswordCard.vue";
import PageLayout from "@/layout/PageLayout.vue";
import type { ApiToken, ApiTokenAbility } from "@/types";

defineProps<{
    tokens?: { data: ApiToken[] } | null;
    tokenAbilities: ApiTokenAbility[];
}>();
</script>

<template>
    <PageLayout title="Settings">
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-2">
            <PasswordCard />
            <ApiTokensCard :tokens="tokens" :token-abilities="tokenAbilities" />
        </div>
    </PageLayout>
</template>
