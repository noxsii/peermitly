<script setup lang="ts">
import { Deferred, Link } from "@inertiajs/vue3";
import { Download, KeyRound, Plus, Settings2 } from "@lucide/vue";
import { ref } from "vue";
import LicenseKeyTable from "@/components/license-keys/LicenseKeyTable.vue";
import CreateLicenseKeyDialog from "@/components/dialogs/CreateLicenseKeyDialog.vue";
import type { PaginationMeta } from "@/components/table";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import PageLayout from "@/layout/PageLayout.vue";
import type {
    CustomerOption,
    LicenseKey,
    LicenseKeyType,
    ProductOption,
} from "@/types";

defineProps<{
    types?: { data: LicenseKeyType[] } | null;
    products?: { data: ProductOption[] } | null;
    customers?: { data: CustomerOption[] } | null;
    licenseKeys?: { data: LicenseKey[]; meta: PaginationMeta } | null;
}>();

const createOpen = ref(false);
</script>

<template>
    <PageLayout title="License Keys">
        <template #actions>
            <Link href="/license-keys/types">
                <Button variant="ghost" size="sm">
                    <Settings2 class="size-4" />
                    Manage types
                </Button>
            </Link>
            <Link href="/license-keys/export">
                <Button variant="ghost" size="sm">
                    <Download class="size-4" />
                    Export CSV
                </Button>
            </Link>
            <Link href="/license-keys/bulk">
                <Button variant="ghost" size="sm">
                    <KeyRound class="size-4" />
                    Bulk create
                </Button>
            </Link>
            <Button size="sm" @click="createOpen = true">
                <Plus class="size-4" />
                New key
            </Button>
        </template>

        <div class="grid max-w-7xl grid-cols-1 gap-4 xl:grid-cols-3">
            <Card title="License Key Types" class="xl:col-span-1">
                <template #actions>
                    <Link href="/license-keys/types">
                        <Button variant="ghost" size="icon-sm">
                            <Settings2 class="size-4" />
                        </Button>
                    </Link>
                </template>
                <Deferred data="types">
                    <template #fallback>
                        <div class="space-y-2">
                            <Skeleton class="h-8 w-full" />
                            <Skeleton class="h-8 w-full" />
                            <Skeleton class="h-8 w-4/5" />
                        </div>
                    </template>
                    <ul v-if="types?.data?.length" class="space-y-1.5">
                        <li
                            v-for="type in types.data"
                            :key="type.uuid"
                            class="flex items-center justify-between text-sm"
                        >
                            <Link
                                :href="`/license-keys/types/${type.uuid}/edit`"
                                class="hover:text-primary truncate font-medium"
                            >
                                {{ type.name }}
                            </Link>
                            <span class="text-muted-foreground text-xs">
                                {{ type.license_keys_count ?? 0 }} keys
                            </span>
                        </li>
                    </ul>
                    <p v-else class="text-muted-foreground text-sm">
                        No types yet.
                        <Link
                            href="/license-keys/types"
                            class="text-primary underline"
                        >
                            Create one
                        </Link>
                        to issue keys.
                    </p>
                </Deferred>
            </Card>

            <Card title="License Keys" class="xl:col-span-2">
                <Deferred data="licenseKeys">
                    <template #fallback>
                        <div class="space-y-2">
                            <Skeleton class="h-9 w-full" />
                            <Skeleton class="h-9 w-full" />
                            <Skeleton class="h-9 w-full" />
                            <Skeleton class="h-9 w-full" />
                        </div>
                    </template>
                    <LicenseKeyTable
                        :rows="licenseKeys?.data ?? []"
                        :pagination="licenseKeys?.meta"
                    />
                </Deferred>
            </Card>
        </div>

        <CreateLicenseKeyDialog
            v-model:open="createOpen"
            :types="types?.data ?? []"
            :products="products?.data ?? []"
            :customers="customers?.data ?? []"
        />
    </PageLayout>
</template>
