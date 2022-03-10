import { computed, onMounted, reactive, ref } from "vue";

const wells = reactive([]);
const selectedWell = ref({});

export default () => {
  const setWells = (payload) => {
    Object.assign(wells, payload);
  };

  const setSelectedWell = (payload) => {
    selectedWell.value = payload;
  };

  const getWells = computed(() => wells);

  const getSelectedWell = computed(() => selectedWell.value);

  return {
    setWells,
    setSelectedWell,
    getWells,
    getSelectedWell,
  };
};
