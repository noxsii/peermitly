<script setup lang="ts">
import { Deferred, Form, Link } from "@inertiajs/vue3";
import { ArrowLeft, Copy, Pencil } from "@lucide/vue";
import { ref } from "vue";
import LicenseKeyStatusBadge from "@/components/license-keys/LicenseKeyStatusBadge.vue";
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
import { Textarea } from "@/components/ui/textarea";
import PageLayout from "@/layout/PageLayout.vue";
import type { LicenseKey, LicenseValidityUnit } from "@/types";

const extendUnit = ref<LicenseValidityUnit>("months");

const props = defineProps<{
    licenseKey?: { data: LicenseKey } | null;
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

        <div class="grid max-w-5xl grid-cols-1 gap-4 lg:grid-cols-3">
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
                                variant="ghost"
                                size="icon-sm"
                                @click="copy"
                            >
                                <Copy class="size-4" />
                            </Button>
                        </div>
                        <p v-if="copied" class="text-xs text-emerald-500">
                            Copied!
                        </p>
                        <div class="flex flex-wrap gap-2">
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
                        </div>
                        <dl
                            class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm md:grid-cols-3"
                        >
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
                    <Form
                        v-if="licenseKey?.data"
                        :action="`/license-keys/${licenseKey.data.uuid}/revoke`"
                        method="post"
                        class="space-y-3"
                        #default="{ errors, processing }"
                    >
                        <Label for="reason">Reason</Label>
                        <Textarea
                            id="reason"
                            name="reason"
                            placeholder="Customer cancelled the subscription…"
                        />
                        <p
                            v-if="errors.reason"
                            class="text-destructive text-sm"
                        >
                            {{ errors.reason }}
                        </p>
                        <Button
                            type="submit"
                            variant="destructive"
                            :disabled="processing"
                        >
                            Revoke key
                        </Button>
                    </Form>
                </Card>

                <Card title="Extend">
                    <Form
                        v-if="licenseKey?.data"
                        :action="`/license-keys/${licenseKey.data.uuid}/extend`"
                        method="post"
                        class="space-y-3"
                        #default="{ processing }"
                    >
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <Label for="amount">Amount</Label>
                                <Input
                                    id="amount"
                                    name="amount"
                                    type="number"
                                    min="1"
                                    default-value="12"
                                />
                            </div>
                            <div>
                                <Label>Unit</Label>
                                <Select v-model="extendUnit" name="unit">
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
                        <Button type="submit" :disabled="processing">
                            Extend
                        </Button>
                    </Form>
                </Card>

                <Card title="Actions">
                    <div class="flex flex-col gap-2">
                        <Link
                            v-if="licenseKey?.data"
                            :href="`/license-keys/${licenseKey.data.uuid}/edit`"
                        >
                            <Button
                                variant="ghost"
                                class="w-full justify-start"
                            >
                                <Pencil class="size-4" />
                                Edit settings
                            </Button>
                        </Link>
                        <Form
                            v-if="
                                licenseKey?.data &&
                                ['revoked', 'expired'].includes(
                                    licenseKey.data.status,
                                )
                            "
                            :action="`/license-keys/${licenseKey.data.uuid}/restore`"
                            method="post"
                            #default="{ processing }"
                        >
                            <Button
                                type="submit"
                                variant="ghost"
                                class="w-full justify-start"
                                :disabled="processing"
                            >
                                Restore
                            </Button>
                        </Form>
                    </div>
                </Card>
            </div>
        </div>
    </PageLayout>
</template>
