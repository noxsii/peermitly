<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { ArrowLeft } from "@lucide/vue";
import LicenseKeyTypeForm from "@/components/license-keys/LicenseKeyTypeForm.vue";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import PageLayout from "@/layout/PageLayout.vue";
</script>

<template>
    <PageLayout title="New License Key Type">
        <template #actions>
            <Link href="/license-keys/types">
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
        </template>

        <Card title="Type Details" class="max-w-2xl">
            <LicenseKeyTypeForm
                action="/license-keys/types"
                submit-label="Create type"
            />
        </Card>
    </PageLayout>
</template>
