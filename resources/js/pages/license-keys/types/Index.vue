<script setup lang="ts">
import { Deferred, Link } from "@inertiajs/vue3";
import { ArrowLeft } from "@lucide/vue";
import LicenseKeyTypeForm from "@/components/license-keys/LicenseKeyTypeForm.vue";
import LicenseKeyTypeTable from "@/components/license-keys/LicenseKeyTypeTable.vue";
import type { PaginationMeta } from "@/components/table";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import PageLayout from "@/layout/PageLayout.vue";
import type { LicenseKeyType } from "@/types";

defineProps<{
    types?: { data: LicenseKeyType[]; meta: PaginationMeta } | null;
}>();
</script>

<template>
    <PageLayout title="License Key Types">
        <template #actions>
            <Link href="/license-keys">
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back to keys
                </Button>
            </Link>
        </template>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2 xl:items-start">
            <Card title="Types">
                <Deferred data="types">
                    <template #fallback>
                        <div class="space-y-2">
                            <Skeleton class="h-9 w-full" />
                            <Skeleton class="h-9 w-full" />
                            <Skeleton class="h-9 w-full" />
                        </div>
                    </template>
                    <LicenseKeyTypeTable
                        :rows="types?.data ?? []"
                        :pagination="types?.meta"
                    />
                </Deferred>
            </Card>

            <Card title="New License Key Type">
                <LicenseKeyTypeForm
                    action="/license-keys/types"
                    submit-label="Create type"
                />
            </Card>
        </div>
    </PageLayout>
</template>
