<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Chirp from "@/Components/Chirp.vue";

defineProps(["chirps"]);

const form = useForm({
  message: "",
});
</script>

<template>
  <Head title="Launchpad" />

  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      <form
        @submit.prevent="
          form.post(route('chirps.store'), {
            onSuccess: () => {
              form.reset();
            },
          })
        "
      >
        <textarea
          v-model="form.message"
          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          placeholder="What's happening?"
        />
        <InputError :message="form.errors.message" class="mt-2" />

        <PrimaryButton class="mt-4">Chirp</PrimaryButton>
      </form>

      <div class="flex flex-col gap-6 mt-6 divide-y">
        <Chirp v-for="chirp in chirps" :key="chirp.id" :chirp="chirp" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
