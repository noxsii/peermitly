<script setup lang="ts">
import { Deferred, Form, Link } from "@inertiajs/vue3";
import { ArrowLeft, Loader2 } from "@lucide/vue";
import { ref, watch } from "vue";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Skeleton } from "@/components/ui/skeleton";
import { Switch } from "@/components/ui/switch";
import PageLayout from "@/layout/PageLayout.vue";
import type { CustomerOption, LicenseKey } from "@/types";

const props = defineProps<{
    licenseKey?: { data: LicenseKey } | null;
    customers?: { data: CustomerOption[] } | null;
}>();

const customerUuid = ref<string>("");

watch(
    () => props.licenseKey?.data?.customer?.uuid,
    (uuid) => {
        if (uuid) customerUuid.value = uuid;
    },
    { immediate: true },
);
</script>

<template>
    <PageLayout title="Edit License Key">
        <template #actions>
            <Link
                v-if="licenseKey?.data"
                :href="`/license-keys/${licenseKey.data.uuid}`"
            >
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
        </template>

        <Card title="Settings" class="max-w-2xl">
            <Deferred :data="['licenseKey', 'customers']">
                <template #fallback>
                    <div class="space-y-3">
                        <Skeleton class="h-9 w-full" />
                        <Skeleton class="h-9 w-full" />
                        <Skeleton class="h-9 w-full" />
                    </div>
                </template>
                <Form
                    v-if="licenseKey?.data"
                    :action="`/license-keys/${licenseKey.data.uuid}`"
                    method="patch"
                    class="space-y-5"
                    #default="{ errors, processing }"
                >
                    <div class="space-y-2">
                        <Label>Customer</Label>
                        <Select v-model="customerUuid" name="customer_uuid">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="No customer" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="customer in customers?.data ?? []"
                                    :key="customer.uuid"
                                    :value="customer.uuid"
                                >
                                    {{ customer.email }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div class="space-y-2">
                        <Label for="max_activations">Maximum activations</Label>
                        <Input
                            id="max_activations"
                            name="max_activations"
                            type="number"
                            min="1"
                            :default-value="
                                licenseKey.data.max_activations ?? undefined
                            "
                            placeholder="Unlimited"
                        />
                    </div>

                    <div
                        class="flex items-center justify-between rounded-md border p-3"
                    >
                        <div>
                            <p class="text-sm font-medium">Require HWID</p>
                        </div>
                        <Switch
                            name="requires_hwid_check"
                            value="1"
                            :default-value="licenseKey.data.requires_hwid_check"
                        />
                    </div>

                    <Button type="submit" :disabled="processing">
                        <Loader2
                            v-if="processing"
                            class="size-4 animate-spin"
                        />
                        Save changes
                    </Button>
                    <p
                        v-if="Object.keys(errors).length"
                        class="text-destructive text-xs"
                    >
                        Please correct the highlighted fields.
                    </p>
                </Form>
            </Deferred>
        </Card>
    </PageLayout>
</template>
