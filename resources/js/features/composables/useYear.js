import { computed, ref } from "vue";

const selectedYear = ref(new Date().getFullYear());

export default () => {
  const setSelectedYear = (payload) => {
    selectedYear.value = payload;
  };

  const getSelectedYear = computed(() => selectedYear.value);

  return {
    setSelectedYear,
    getSelectedYear,
  };
};
