import { computed, ref, watch } from "vue";

const isSidebarOpen = ref(false);
export default () => {
  function toggle() {
    isSidebarOpen.value = !isSidebarOpen.value;
  }

  const setIsSidebarOpenState = (value) => {
    isSidebarOpen.value = value;
  };

  // watch(isSidebarOpen, (newVal, preVal) => handler(newVal), {
  //   immediate: true,
  // });

  // function handler(value) {
  //   console.log("newVal: ", value);
  //   if (process.client) {
  //     if (value) document.body.style.setProperty("overflow", "hidden");
  //     else document.body.style.removeProperty("overflow");
  //   }
  // }

  const isOpen = computed(() => isSidebarOpen.value);

  return { toggle, isOpen, setIsSidebarOpenState };
};
