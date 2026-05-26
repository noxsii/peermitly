<script setup lang="ts">
import { Pencil, Trash2 } from "@lucide/vue";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import type { LicenseKey } from "@/types";

const props = defineProps<{
    licenseKey: LicenseKey;
}>();

defineEmits<{
    edit: [];
    delete: [];
}>();

const canRestore = ["revoked", "expired"].includes(props.licenseKey.status);
</script>

<template>
    <Card title="Actions">
        <div class="flex flex-col gap-2">
            <Button
                variant="ghost"
                class="w-full justify-start"
                type="button"
                @click="$emit('edit')"
            >
                <Pencil class="size-4" />
                Edit settings
            </Button>
            <form
                v-if="canRestore"
                method="post"
                :action="`/license-keys/${licenseKey.uuid}/restore`"
            >
                <Button
                    type="submit"
                    variant="ghost"
                    class="w-full justify-start"
                >
                    Restore
                </Button>
            </form>
            <Button
                variant="ghost"
                class="text-destructive hover:text-destructive w-full justify-start"
                type="button"
                @click="$emit('delete')"
            >
                <Trash2 class="size-4" />
                Delete key
            </Button>
        </div>
    </Card>
</template>
