<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import {
    Bell,
    Bookmark,
    Layers,
    LayoutDashboard,
    LifeBuoy,
    Map,
    Settings,
} from "@lucide/vue";
import { computed } from "vue";
import type { NavItem } from "@/types";

const primary: NavItem[] = [
    { label: "Dashboard", href: "/dashboard", icon: LayoutDashboard },
    { label: "Operations", href: "/dashboard", icon: Layers },
    { label: "Map", href: "/dashboard", icon: Map },
    { label: "Notifications", href: "/dashboard", icon: Bell },
    { label: "Saved", href: "/dashboard", icon: Bookmark },
];

const secondary: NavItem[] = [
    { label: "Help", href: "/dashboard", icon: LifeBuoy },
    { label: "Settings", href: "/dashboard", icon: Settings },
];

const page = usePage();
const currentUrl = computed(() => page.url);
</script>

<template>
    <aside
        class="bg-background text-foreground flex w-16 shrink-0 flex-col items-center justify-between py-4"
    >
        <div class="flex flex-col items-center gap-1">
            <Link
                v-for="item in primary"
                :key="item.label"
                :href="item.href"
                :aria-label="item.label"
                :aria-current="currentUrl === item.href ? 'page' : undefined"
                class="text-foreground/70 hover:bg-muted hover:text-foreground aria-[current=page]:bg-muted aria-[current=page]:text-foreground flex size-9 items-center justify-center rounded-lg transition-colors"
            >
                <component :is="item.icon" class="size-4" />
            </Link>
        </div>

        <div class="flex flex-col items-center gap-1">
            <Link
                v-for="item in secondary"
                :key="item.label"
                :href="item.href"
                :aria-label="item.label"
                class="text-foreground/70 hover:bg-muted hover:text-foreground flex size-9 items-center justify-center rounded-lg transition-colors"
            >
                <component :is="item.icon" class="size-4" />
            </Link>
        </div>
    </aside>
</template>
