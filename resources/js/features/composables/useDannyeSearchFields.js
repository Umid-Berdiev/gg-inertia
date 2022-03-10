import { computed, ref } from "vue";

const selectedWell = ref({});
const selectedYear = ref(new Date().getFullYear());

export default () => {
  const setSelectedWell = (payload) => {
    selectedWell.value = payload;
  };

  const setSelectedYear = (payload) => {
    selectedYear.value = payload;
  };

  const getSelectedWell = computed(() => selectedWell.value);
  const getSelectedYear = computed(() => selectedYear.value);

  return {
    setSelectedWell,
    setSelectedYear,
    getSelectedWell,
    getSelectedYear,
  };
};
