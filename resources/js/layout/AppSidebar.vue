<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import { LayoutDashboard, LifeBuoy, Settings } from "@lucide/vue";
import { computed } from "vue";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/components/ui/tooltip";
import type { NavItem } from "@/types";

const primary: NavItem[] = [
    { label: "Dashboard", href: "/dashboard", icon: LayoutDashboard },
];

const secondary: NavItem[] = [
    { label: "Help", href: "/dashboard", icon: LifeBuoy },
    { label: "Settings", href: "/dashboard", icon: Settings },
];

const page = usePage();
const currentUrl = computed(() => page.url);
</script>

<template>
    <TooltipProvider :delay-duration="100">
        <aside
            class="bg-background text-foreground flex w-16 shrink-0 flex-col items-center justify-between py-4"
        >
            <div class="flex flex-col items-center gap-1">
                <Tooltip v-for="item in primary" :key="item.label">
                    <TooltipTrigger as-child>
                        <Link
                            :href="item.href"
                            :aria-label="item.label"
                            :aria-current="
                                currentUrl === item.href ? 'page' : undefined
                            "
                            class="text-foreground/70 hover:bg-muted hover:text-foreground aria-[current=page]:bg-muted aria-[current=page]:text-foreground flex size-9 items-center justify-center rounded-lg transition-colors"
                        >
                            <component :is="item.icon" class="size-4" />
                        </Link>
                    </TooltipTrigger>
                    <TooltipContent side="right" :side-offset="8">
                        {{ item.label }}
                    </TooltipContent>
                </Tooltip>
            </div>

            <div class="flex flex-col items-center gap-1">
                <Tooltip v-for="item in secondary" :key="item.label">
                    <TooltipTrigger as-child>
                        <Link
                            :href="item.href"
                            :aria-label="item.label"
                            class="text-foreground/70 hover:bg-muted hover:text-foreground flex size-9 items-center justify-center rounded-lg transition-colors"
                        >
                            <component :is="item.icon" class="size-4" />
                        </Link>
                    </TooltipTrigger>
                    <TooltipContent side="right" :side-offset="8">
                        {{ item.label }}
                    </TooltipContent>
                </Tooltip>
            </div>
        </aside>
    </TooltipProvider>
</template>
