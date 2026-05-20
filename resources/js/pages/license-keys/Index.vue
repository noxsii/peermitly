<script setup lang="ts">
import Card from "@/components/Card.vue";
import PageLayout from "@/layout/PageLayout.vue";
</script>

<template>
    <PageLayout title="License Keys">
        <div class="grid max-w-6xl grid-cols-1 gap-4 lg:grid-cols-3">
            <Card title="License Key Types" class="lg:col-span-1">
                <p class="text-muted-foreground text-sm">
                    No license key types yet.
                </p>
            </Card>

            <Card title="License Keys" class="lg:col-span-2">
                <p class="text-muted-foreground text-sm">
                    No license keys yet.
                </p>
            </Card>
        </div>
    </PageLayout>
</template>
