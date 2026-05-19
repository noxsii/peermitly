<script setup lang="ts">
import { Form, Head } from "@inertiajs/vue3";
import { Loader2 } from "@lucide/vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
</script>

<template>
    <Head title="Sign in" />

    <main
        class="bg-muted/40 flex min-h-screen items-center justify-center px-4"
    >
        <div
            class="bg-card text-card-foreground w-full max-w-md rounded-2xl border p-8 shadow-sm"
        >
            <div class="mb-6 space-y-1">
                <h1 class="text-2xl font-semibold tracking-tight">Sign in</h1>
                <p class="text-muted-foreground text-sm">
                    Enter your email and password to continue.
                </p>
            </div>

            <Form
                action="/login"
                method="post"
                class="space-y-5"
                #default="{ errors, processing }"
            >
                <div class="space-y-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        :aria-invalid="!!errors.email"
                    />
                    <p v-if="errors.email" class="text-destructive text-sm">
                        {{ errors.email }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        :aria-invalid="!!errors.password"
                    />
                    <p v-if="errors.password" class="text-destructive text-sm">
                        {{ errors.password }}
                    </p>
                </div>

                <Button type="submit" class="w-full" :disabled="processing">
                    <Loader2 v-if="processing" class="size-4 animate-spin" />
                    Sign in
                </Button>
            </Form>
        </div>
    </main>
</template>