<script setup lang="ts">
import { Monitor, Moon, Search, Sun } from "@lucide/vue";
import { Button } from "@/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Input } from "@/components/ui/input";
import { useAppearance } from "@/composables/useAppearance";
import Logo from "@/layout/Logo.vue";
import UserMenu from "@/layout/UserMenu.vue";
import type { Appearance } from "@/types";

const { mode, set: setAppearance } = useAppearance();

const appearanceOptions: Array<{
    value: Appearance;
    label: string;
    icon: typeof Sun;
}> = [
    { value: "light", label: "Light", icon: Sun },
    { value: "dark", label: "Dark", icon: Moon },
    { value: "auto", label: "System", icon: Monitor },
];
</script>

<template>
    <header
        class="bg-background grid h-14 shrink-0 grid-cols-[1fr_auto_1fr] items-center gap-3 px-4"
    >
        <div class="flex items-center">
            <Logo />
        </div>

        <div class="relative w-full max-w-xl justify-self-center">
            <Search
                class="text-muted-foreground pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2"
            />
            <Input
                type="search"
                placeholder="Search…"
                aria-label="Search"
                class="bg-muted/60 min-w-2xl h-9 rounded-full border-transparent pl-9 shadow-none"
            />
        </div>

        <div class="flex items-center justify-end gap-2">
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button
                        size="icon-sm"
                        variant="ghost"
                        class="rounded-full"
                        aria-label="Toggle appearance"
                    >
                        <Sun class="size-4 dark:hidden" />
                        <Moon class="hidden size-4 dark:block" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" class="w-40">
                    <DropdownMenuItem
                        v-for="option in appearanceOptions"
                        :key="option.value"
                        :data-state="
                            mode === option.value ? 'checked' : undefined
                        "
                        class="data-[state=checked]:bg-accent data-[state=checked]:text-accent-foreground"
                        @select="setAppearance(option.value)"
                    >
                        <component :is="option.icon" class="size-4" />
                        {{ option.label }}
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <UserMenu />
        </div>
    </header>
</template>
