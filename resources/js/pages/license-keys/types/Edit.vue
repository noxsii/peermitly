<script setup lang="ts">
import { Deferred, Link } from "@inertiajs/vue3";
import { ArrowLeft } from "@lucide/vue";
import LicenseKeyTypeForm from "@/components/license-keys/LicenseKeyTypeForm.vue";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import PageLayout from "@/layout/PageLayout.vue";
import type { LicenseKeyType } from "@/types";

defineProps<{
    type?: { data: LicenseKeyType } | null;
}>();
</script>

<template>
    <PageLayout title="Edit License Key Type">
        <template #actions>
            <Link href="/license-keys/types">
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
        </template>

        <Card title="Type Details" class="max-w-2xl">
            <Deferred data="type">
                <template #fallback>
                    <div class="space-y-3">
                        <Skeleton class="h-9 w-full" />
                        <Skeleton class="h-9 w-full" />
                        <Skeleton class="h-9 w-full" />
                    </div>
                </template>
                <LicenseKeyTypeForm
                    v-if="type?.data"
                    :action="`/license-keys/types/${type.data.uuid}`"
                    method="patch"
                    submit-label="Save changes"
                    :initial="type.data"
                />
            </Deferred>
        </Card>
    </PageLayout>
</template>
