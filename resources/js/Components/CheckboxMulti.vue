<template>
    <div
        v-for="option in options"
        class="form-control"
        :key="option"
    >
        <check-box
            :checked="value.includes(option.id)"
            @update:checked="check(option.id, $event)"
            :fieldId="option.name"
            :label="option.name"
        />
    </div>
</template>

<script>
import Checkbox from "@/Components/Checkbox.vue";

export default {
  emits: ["update:value"],
  props: {
    value: {
      type: Array,
      required: true,
      default: [],
    },
    options: {
      type: Array,
      required: true,
      validator: (value) => {
        const hasNameKey = value.every((option) =>
          Object.keys(option).includes("name")
        );
        const hasIdKey = value.every((option) =>
          Object.keys(option).includes("id")
        );
        return hasNameKey && hasIdKey;
      },
    },
  },
  setup(props, context) {
    const check = (optionId, checked) => {
      let updatedValue = [...props.value];
      if (checked) {
        updatedValue.push(optionId);
      } else {
        updatedValue.splice(updatedValue.indexOf(optionId), 1);
      }
      context.emit("update:value", updatedValue);
    };

    return {
      check,
    };
  },
  components: {
    "check-box": Checkbox,
  },
};
</script>
