<script setup lang="ts">
import { Deferred, Link } from "@inertiajs/vue3";
import { ArrowLeft } from "@lucide/vue";
import CustomerForm from "@/components/license-keys/CustomerForm.vue";
import CustomerTable from "@/components/license-keys/CustomerTable.vue";
import Card from "@/components/Card.vue";
import type { PaginationMeta } from "@/components/table";
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import PageLayout from "@/layout/PageLayout.vue";
import type { CustomerOption } from "@/types";

defineProps<{
    customers?: { data: CustomerOption[]; meta: PaginationMeta } | null;
}>();
</script>

<template>
    <PageLayout title="Customers">
        <template #actions>
            <Link href="/license-keys">
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back to keys
                </Button>
            </Link>
        </template>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2 xl:items-start">
            <Card title="Customers">
                <Deferred data="customers">
                    <template #fallback>
                        <div class="space-y-2">
                            <Skeleton class="h-9 w-full" />
                            <Skeleton class="h-9 w-full" />
                            <Skeleton class="h-9 w-full" />
                        </div>
                    </template>
                    <CustomerTable
                        :rows="customers?.data ?? []"
                        :pagination="customers?.meta"
                    />
                </Deferred>
            </Card>

            <Card title="New Customer">
                <CustomerForm
                    action="/license-keys/customers"
                    submit-label="Create customer"
                />
            </Card>
        </div>
    </PageLayout>
</template>
