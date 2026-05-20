<script setup lang="ts">
import { Deferred, Link } from "@inertiajs/vue3";
import { ArrowLeft } from "@lucide/vue";
import LicenseKeyForm from "@/components/license-keys/LicenseKeyForm.vue";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import PageLayout from "@/layout/PageLayout.vue";
import type {
    CustomerOption,
    LicenseKeyType,
    ProductOption,
} from "@/types";

defineProps<{
    types?: { data: LicenseKeyType[] } | null;
    products?: { data: ProductOption[] } | null;
    customers?: { data: CustomerOption[] } | null;
}>();
</script>

<template>
    <PageLayout title="Bulk Create License Keys">
        <template #actions>
            <Link href="/license-keys">
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
        </template>

        <Card title="Bulk Settings" class="max-w-2xl">
            <Deferred :data="['types', 'products', 'customers']">
                <template #fallback>
                    <div class="space-y-4">
                        <Skeleton class="h-9 w-full" />
                        <Skeleton class="h-9 w-full" />
                        <Skeleton class="h-9 w-full" />
                    </div>
                </template>
                <LicenseKeyForm
                    bulk
                    action="/license-keys/bulk"
                    submit-label="Create keys"
                    :types="types?.data ?? []"
                    :products="products?.data ?? []"
                    :customers="customers?.data ?? []"
                />
            </Deferred>
        </Card>
    </PageLayout>
</template>
