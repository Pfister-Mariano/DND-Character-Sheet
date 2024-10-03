<template>
    <div class="defaultContainer">
        <div class="innerContainer accordion" v-for="(ability, index) in localCharacter.abilities">
            <div class="accordionHead">
                <div class="accordionToggle" @click="toggleAccordion($event)">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="accordionTitle">
                    <input type="text" v-model="ability.name" @input="updateCharacterData">
                </div>
                <div class="accordionLevel">
                    <input type="text" v-model="ability.levelRequirement" maxlength="2" @input="updateCharacterData">
                </div>
            </div>
            <div class="accordionContent">
                <div class="accordionHighlights">
                    <div>
                        <input type="text" v-model="ability.origin" @input="updateCharacterData">
                    </div>
                    <div>
                        <input type="text" v-model="ability.useTime" @input="updateCharacterData">
                    </div>
                </div>
                <div class="accordionText">
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';

const props = defineProps({
    characterData: {
        type: Object,
        required: true
    }
});

const localCharacter = ref(props.characterData);

watch(localCharacter, (newVal) => {
    localCharacter.value = newVal;
    props.characterData = newVal
});

const emit = defineEmits(['update:characterData']);

function updateCharacterData(event) {
    const newSize = Number(event.target.value);
    emit('update:characterData', newSize);
}

function toggleAccordion(event) {
  // Find the closest parent with the "accordion" class and toggle "active"
  const accordionElement = event.target.closest('.accordion');
  if (accordionElement) {
    accordionElement.classList.toggle('active');
  }
}
</script>

<style scoped lang="scss">
.innerContainer.accordion{
    padding: 0;
    gap: 0;
    .accordionHead{
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 1.20rem;

        .accordionToggle{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 5px;
            cursor: pointer;
            i{
                color: var(--colorBlueLight);
                font-size: 1.2rem;
                transform: rotate(-90deg);
                transition: var(--transition);
            }
        }
        .accordionTitle{
            width: 100%;
            padding: 5px 0 5px 5px;
            input{
                width: 100%;
                letter-spacing: 0.05em;
            }
        }
        .accordionLevel{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 26px;
            width: 30px;
            margin: 5px 10px;
            background-color: var(--colorBlueDark);
            color: var(--colorWhite);
            border-radius: 6px;
            input{
                padding: 0;
                line-height: 20px;
                text-align: center;
            }
        }
    }
    .accordionContent{
        margin-top: 0px;
        padding: 0 10px;
        overflow: hidden;
        height: 0;
        display: flex;
        flex-direction: column;
        gap: 5px;
        .accordionHighlights{
            display: flex;
            gap: 5px;
            div{
                width: 100%;
                padding: 5px 10px;
                border-radius: 6px;
                background-color: var(--colorSanityGain);
                input{
                    width: 100%;
                }
            }
        }
        .accordionText{
            background-color: var(--colorBG2);
            min-height: 1lh;
        }
    }
    &.active{
        i{
            transform: rotate(0deg) !important;
        }
        .accordionContent{
            margin-top: 10px;
            padding: 0 10px 10px 10px;
            height: auto;
        }
    }
}
</style>
