import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useCompanyStore = defineStore('company', () => {
  const company = ref(null);
  const isLoading = ref(false);
  const error = ref(null);

  // Fetch user data from the server
  const fetchCompany = async () => {
    isLoading.value = true;
    error.value = null;

    try {
      const response = await fetch('/api/company'); // Replace with your API endpoint
      if (!response.ok) {
        throw new Error('Failed to fetch user data');
      }
      user.value = await response.json(); // Assume the API returns user data in JSON format
    } catch (err) {
      error.value = err.message;
    } finally {
      isLoading.value = false;
    }
  };

  return {
    company,
    isLoading,
    error,
    fetchCompany,
  };
});
