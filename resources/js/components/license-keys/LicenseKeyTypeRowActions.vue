<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Pencil, Trash2 } from "@lucide/vue";
import { ref } from "vue";
import ConfirmDialog from "@/components/dialogs/ConfirmDialog.vue";
import { Button } from "@/components/ui/button";
import type { LicenseKeyType } from "@/types";

const props = defineProps<{
    type: LicenseKeyType;
}>();

const emit = defineEmits<{
    confirmDelete: [uuid: string];
}>();

const deleteOpen = ref(false);

const onConfirm = () => {
    emit("confirmDelete", props.type.uuid);
};
</script>

<template>
    <div class="flex justify-end gap-1">
        <Link :href="`/license-keys/types/${type.uuid}/edit`">
            <Button variant="ghost" size="icon-sm" type="button">
                <Pencil class="size-4" />
            </Button>
        </Link>
        <Button
            variant="ghost"
            size="icon-sm"
            type="button"
            @click="deleteOpen = true"
        >
            <Trash2 class="text-destructive size-4" />
        </Button>

        <ConfirmDialog
            v-model:open="deleteOpen"
            title="Delete license key type?"
            :description="`This will permanently remove '${type.name}'. License keys created from this type are not affected.`"
            confirm-label="Delete"
            destructive
            @confirm="onConfirm"
        />
    </div>
</template>
