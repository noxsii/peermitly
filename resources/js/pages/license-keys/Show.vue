<script setup lang="ts">
import { Deferred, Link, useForm } from "@inertiajs/vue3";
import { ArrowLeft, Check, Copy, Pencil } from "@lucide/vue";

import { computed, ref } from "vue";
import EditLicenseKeyDialog from "@/components/dialogs/EditLicenseKeyDialog.vue";
import LicenseKeyStatusBadge from "@/components/license-keys/LicenseKeyStatusBadge.vue";
import Card from "@/components/Card.vue";
import InputError from "@/components/InputError.vue";
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
import { Textarea } from "@/components/ui/textarea";
import PageLayout from "@/layout/PageLayout.vue";
import type { CustomerOption, LicenseKey, LicenseValidityUnit } from "@/types";

const editOpen = ref(false);
const extendSuccess = ref(false);
const revokeSuccess = ref(false);

const props = defineProps<{
    licenseKey?: { data: LicenseKey } | null;
    customers?: { data: CustomerOption[] } | null;
}>();

const copied = ref(false);

const copy = async () => {
    if (!props.licenseKey?.data) return;
    await navigator.clipboard.writeText(props.licenseKey.data.key);
    copied.value = true;
    setTimeout(() => (copied.value = false), 2000);
};

const formatDate = (value: string | null): string => {
    if (!value) {
        return "—";
    }
    return new Date(value).toLocaleString();
};

const validityLabel = computed(() => {
    const k = props.licenseKey?.data;
    if (!k) return "—";
    if (k.validity_unit === "lifetime") return "Lifetime";
    if (k.validity_amount === null) return "—";
    return `${k.validity_amount} ${k.validity_unit}`;
});

const daysRemaining = computed(() => {
    const k = props.licenseKey?.data;
    if (!k || k.validity_unit === "lifetime") return null;
    if (!k.expires_at) return null;
    const diff = new Date(k.expires_at).getTime() - Date.now();
    return Math.max(0, Math.ceil(diff / (1000 * 60 * 60 * 24)));
});

const remainingLabel = computed(() => {
    const k = props.licenseKey?.data;
    if (!k) return "—";
    if (k.validity_unit === "lifetime") return "∞ Lifetime";
    if (daysRemaining.value === null) return "Not activated yet";
    if (daysRemaining.value === 0) return "Expired";
    return `${daysRemaining.value} days remaining`;
});

const extendForm = useForm<{
    amount: number;
    unit: LicenseValidityUnit;
}>({
    amount: 12,
    unit: "months",
});

const revokeForm = useForm<{ reason: string }>({ reason: "" });

const submitExtend = () => {
    if (!props.licenseKey?.data) return;
    extendForm.post(`/license-keys/${props.licenseKey.data.uuid}/extend`, {
        preserveScroll: true,
        onSuccess: () => {
            extendSuccess.value = true;
            setTimeout(() => (extendSuccess.value = false), 3000);
        },
    });
};

const submitRevoke = () => {
    if (!props.licenseKey?.data) return;
    revokeForm.post(`/license-keys/${props.licenseKey.data.uuid}/revoke`, {
        preserveScroll: true,
        onSuccess: () => {
            revokeSuccess.value = true;
            revokeForm.reset();
            setTimeout(() => (revokeSuccess.value = false), 3000);
        },
    });
};
</script>

<template>
    <PageLayout title="License Key">
        <template #actions>
            <Link href="/license-keys">
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
        </template>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <Card title="Key" class="lg:col-span-2">
                <Deferred data="licenseKey">
                    <template #fallback>
                        <div class="space-y-3">
                            <Skeleton class="h-10 w-full" />
                            <Skeleton class="h-6 w-1/3" />
                        </div>
                    </template>
                    <div v-if="licenseKey?.data" class="space-y-4">
                        <div class="flex items-center gap-2">
                            <code
                                class="bg-muted/40 flex-1 truncate rounded-md p-2 font-mono text-sm"
                            >
                                {{ licenseKey.data.key }}
                            </code>
                            <Button
                                variant="outline"
                                size="icon-sm"
                                type="button"
                                @click="copy"
                            >
                                <Check
                                    v-if="copied"
                                    class="size-4 text-emerald-500"
                                />
                                <Copy v-else class="size-4" />
                            </Button>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <LicenseKeyStatusBadge
                                :status="licenseKey.data.status"
                            />
                            <span
                                v-if="licenseKey.data.requires_hwid_check"
                                class="border-border rounded-md border px-2 py-0.5 text-xs"
                            >
                                HWID required
                            </span>
                            <span
                                v-if="
                                    licenseKey.data.validity_unit === 'lifetime'
                                "
                                class="border-border rounded-md border px-2 py-0.5 text-xs"
                            >
                                Lifetime
                            </span>
                            <span
                                class="ml-auto text-sm font-medium"
                                :class="
                                    daysRemaining !== null && daysRemaining < 30
                                        ? 'text-destructive'
                                        : 'text-foreground'
                                "
                            >
                                {{ remainingLabel }}
                            </span>
                        </div>

                        <dl
                            class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm md:grid-cols-3"
                        >
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Validity
                                </dt>
                                <dd>{{ validityLabel }}</dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Product
                                </dt>
                                <dd>
                                    {{ licenseKey.data.product.name ?? "—" }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Customer
                                </dt>
                                <dd>
                                    {{ licenseKey.data.customer?.email ?? "—" }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Type
                                </dt>
                                <dd>{{ licenseKey.data.type.name ?? "—" }}</dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Activated
                                </dt>
                                <dd>
                                    {{
                                        formatDate(licenseKey.data.activated_at)
                                    }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Expires
                                </dt>
                                <dd>
                                    {{ formatDate(licenseKey.data.expires_at) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Checks
                                </dt>
                                <dd>{{ licenseKey.data.check_count }}</dd>
                            </div>
                            <div>
                                <dt class="text-muted-foreground text-xs">
                                    Max activations
                                </dt>
                                <dd>
                                    {{
                                        licenseKey.data.max_activations ??
                                        "Unlimited"
                                    }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </Deferred>
            </Card>

            <div class="space-y-4">
                <Card title="Revoke">
                    <form @submit.prevent="submitRevoke" class="space-y-3">
                        <Label for="reason">Reason</Label>
                        <Textarea
                            id="reason"
                            v-model="revokeForm.reason"
                            :aria-invalid="!!revokeForm.errors.reason"
                            placeholder="Customer cancelled the subscription…"
                        />
                        <InputError :message="revokeForm.errors.reason" />
                        <Button
                            type="submit"
                            variant="destructive"
                            :disabled="revokeForm.processing"
                        >
                            Revoke key
                        </Button>
                        <p
                            v-if="revokeSuccess"
                            class="flex items-center gap-1 text-xs text-emerald-500"
                        >
                            <Check class="size-3" />
                            Key revoked.
                        </p>
                    </form>
                </Card>

                <Card title="Extend">
                    <form @submit.prevent="submitExtend" class="space-y-3">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <Label for="amount">Amount</Label>
                                <Input
                                    id="amount"
                                    type="number"
                                    min="1"
                                    v-model="extendForm.amount"
                                    :aria-invalid="!!extendForm.errors.amount"
                                />
                                <InputError
                                    :message="extendForm.errors.amount"
                                />
                            </div>
                            <div>
                                <Label>Unit</Label>
                                <Select v-model="extendForm.unit">
                                    <SelectTrigger class="w-full">
                                        <SelectValue />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="days">
                                            Days
                                        </SelectItem>
                                        <SelectItem value="months">
                                            Months
                                        </SelectItem>
                                        <SelectItem value="years">
                                            Years
                                        </SelectItem>
                                        <SelectItem value="lifetime">
                                            Lifetime
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                        <Button
                            type="submit"
                            :disabled="extendForm.processing"
                        >
                            Extend
                        </Button>
                        <p
                            v-if="extendSuccess && licenseKey?.data"
                            class="flex items-center gap-1 text-xs text-emerald-500"
                        >
                            <Check class="size-3" />
                            Extended. New expiry:
                            {{ formatDate(licenseKey.data.expires_at) }}
                        </p>
                    </form>
                </Card>

                <Card title="Actions">
                    <div class="flex flex-col gap-2">
                        <Button
                            v-if="licenseKey?.data"
                            variant="ghost"
                            class="w-full justify-start"
                            type="button"
                            @click="editOpen = true"
                        >
                            <Pencil class="size-4" />
                            Edit settings
                        </Button>
                        <form
                            v-if="
                                licenseKey?.data &&
                                ['revoked', 'expired'].includes(
                                    licenseKey.data.status,
                                )
                            "
                            method="post"
                            :action="`/license-keys/${licenseKey.data.uuid}/restore`"
                        >
                            <Button
                                type="submit"
                                variant="ghost"
                                class="w-full justify-start"
                            >
                                Restore
                            </Button>
                        </form>
                    </div>
                </Card>
            </div>
        </div>

        <EditLicenseKeyDialog
            v-if="licenseKey?.data"
            v-model:open="editOpen"
            :license-key="licenseKey.data"
            :customers="customers?.data ?? []"
        />
    </PageLayout>
</template>
