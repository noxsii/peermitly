<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { Check } from "@lucide/vue";
import { ref } from "vue";
import Card from "@/components/Card.vue";
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";

const props = defineProps<{
    uuid: string;
}>();

const success = ref(false);

const form = useForm<{ reason: string }>({ reason: "" });

const submit = () => {
    form.post(`/license-keys/${props.uuid}/revoke`, {
        preserveScroll: true,
        onSuccess: () => {
            success.value = true;
            form.reset();
            setTimeout(() => (success.value = false), 3000);
        },
    });
};
</script>

<template>
    <Card title="Revoke">
        <form @submit.prevent="submit" class="space-y-3">
            <Label for="reason">Reason</Label>
            <Textarea
                id="reason"
                v-model="form.reason"
                :aria-invalid="!!form.errors.reason"
                placeholder="Customer cancelled the subscription…"
            />
            <InputError :message="form.errors.reason" />
            <Button
                type="submit"
                variant="destructive"
                :disabled="form.processing"
            >
                Revoke key
            </Button>
            <p
                v-if="success"
                class="flex items-center gap-1 text-xs text-emerald-500"
            >
                <Check class="size-3" />
                Key revoked.
            </p>
        </form>
    </Card>
</template>
