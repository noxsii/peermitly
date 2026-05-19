<script setup lang="ts">
import { MoreHorizontal, Plus } from "@lucide/vue";
import Card from "@/components/Card.vue";
import { Button } from "@/components/ui/button";
import PageLayout from "@/layout/PageLayout.vue";
</script>

<template>
    <PageLayout title="Dashboard">
        <template #actions>
            <Button size="sm" variant="ghost" class="rounded-full">
                Last 30 days
            </Button>
            <Button size="sm" class="rounded-full">
                <Plus class="size-4" />
                New permit
            </Button>
        </template>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <Card title="Open permits">
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-semibold">128</span>
                    <span class="text-success text-xs font-medium">+12%</span>
                </div>
            </Card>

            <Card title="Pending review">
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-semibold">24</span>
                    <span class="text-muted-foreground text-xs">3 overdue</span>
                </div>
            </Card>

            <Card title="Approved this week">
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-semibold">47</span>
                    <span class="text-success text-xs font-medium">+5%</span>
                </div>
            </Card>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-3">
            <Card title="Recent activity" class="lg:col-span-2">
                <template #actions>
                    <Button size="icon-xs" variant="ghost">
                        <MoreHorizontal class="size-4" />
                    </Button>
                </template>

                <ul class="divide-border divide-y">
                    <li
                        v-for="item in 4"
                        :key="item"
                        class="flex items-center justify-between py-3 text-sm first:pt-0 last:pb-0"
                    >
                        <div>
                            <p class="font-medium">Permit #PRM-{{ 1000 + item }}</p>
                            <p class="text-muted-foreground text-xs">
                                Submitted by user · 2h ago
                            </p>
                        </div>
                        <span
                            class="bg-muted text-muted-foreground rounded-full px-2 py-0.5 text-xs font-medium"
                        >
                            Pending
                        </span>
                    </li>
                </ul>
            </Card>

            <Card title="Team">
                <template #actions>
                    <Button size="icon-xs" variant="ghost">
                        <Plus class="size-4" />
                    </Button>
                </template>

                <div class="space-y-3">
                    <div
                        v-for="initials in ['AD', 'JS', 'MK']"
                        :key="initials"
                        class="flex items-center gap-3"
                    >
                        <div
                            class="bg-primary text-primary-foreground flex size-8 items-center justify-center rounded-full text-xs font-semibold"
                        >
                            {{ initials }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium">Member name</p>
                            <p class="text-muted-foreground truncate text-xs">
                                Admin
                            </p>
                        </div>
                    </div>
                </div>
            </Card>
        </div>
    </PageLayout>
</template>
