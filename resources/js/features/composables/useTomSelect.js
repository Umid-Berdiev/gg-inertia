export default () => {
  const TomSelect = new TomSelect("#select-beast", {
    create: true,
    sortField: {
      field: "text",
      direction: "asc",
    },
  });
};
