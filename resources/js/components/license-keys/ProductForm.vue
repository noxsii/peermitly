<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { Loader2 } from "@lucide/vue";
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Switch } from "@/components/ui/switch";
import { Textarea } from "@/components/ui/textarea";
import type { ProductOption } from "@/types";

const props = defineProps<{
    action: string;
    method?: "post" | "patch";
    submitLabel?: string;
    initial?: ProductOption;
}>();

const emit = defineEmits<{
    success: [];
}>();

const form = useForm<{
    name: string;
    slug: string;
    description: string;
    is_active: boolean;
}>({
    name: props.initial?.name ?? "",
    slug: props.initial?.slug ?? "",
    description: props.initial?.description ?? "",
    is_active: props.initial?.is_active ?? true,
});

const submit = () => {
    const options = {
        onSuccess: () => {
            emit("success");
            if (props.method !== "patch") {
                form.reset();
            }
        },
    };
    if (props.method === "patch") {
        form.patch(props.action, options);
    } else {
        form.post(props.action, options);
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div class="space-y-2">
            <Label for="name">Name</Label>
            <Input
                id="name"
                v-model="form.name"
                :aria-invalid="!!form.errors.name"
                placeholder="OfficeEfficient"
            />
            <InputError :message="form.errors.name" />
        </div>

        <div class="space-y-2">
            <Label for="slug">Slug</Label>
            <Input
                id="slug"
                v-model="form.slug"
                :aria-invalid="!!form.errors.slug"
                placeholder="office-efficient"
            />
            <p class="text-muted-foreground text-xs">
                Used in API requests. Lowercase letters, numbers and dashes
                only.
            </p>
            <InputError :message="form.errors.slug" />
        </div>

        <div class="space-y-2">
            <Label for="description">Description</Label>
            <Textarea
                id="description"
                v-model="form.description"
                :aria-invalid="!!form.errors.description"
                placeholder="What is this product?"
            />
            <InputError :message="form.errors.description" />
        </div>

        <div class="flex items-center justify-between rounded-md border p-3">
            <p class="text-sm font-medium">Active</p>
            <Switch v-model="form.is_active" />
        </div>

        <div class="pt-2">
            <Button type="submit" :disabled="form.processing">
                <Loader2 v-if="form.processing" class="size-4 animate-spin" />
                {{ submitLabel ?? "Save product" }}
            </Button>
        </div>
    </form>
</template>
