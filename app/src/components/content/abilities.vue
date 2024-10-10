<template>
    <div>
        <div class="defaultContainer">
            <div class="innerContainer accordion" v-for="(ability, index) in localCharacter.abilities" :class="accordionAbilityOrigin(ability.levelRequirement)" :style="{'order': ability.order}">
                <div class="accordionHead">
                    <div class="accordionToggle" @click="toggleAccordion($event)">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="accordionTitle">
                        <input type="text" v-model="ability.name" @input="updateCharacterData">
                        <span class="accordionRemove" @click="removeAccordion(index)">
                            <i class="fa-solid fa-x"></i>
                        </span>
                    </div>
                    <div class="accordionLevel">
                        <input type="text" v-model="ability.levelRequirement" @input="updateCharacterData">
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
                        <div class="accordionOrder">
                            <input type="text" v-model="ability.order" maxlength="3" @input="updateCharacterData">
                        </div>
                    </div>
                    <div class="accordionText">
                        <!-- <ckEditorBig :editorText="ability.description"  :editorIndex="index" @update:editorText="(newContent, index) => updateText(newContent, index)"/> -->
                        <ckEditorSmall :editorText="ability.description"  :editorIndex="index" @update:editorText="(newContent, index) => updateText(newContent, index)"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordionAdd" @click="addAccordion()"><i class="fa-solid fa-plus"></i></div>
    </div>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';
import ckEditorSmall from '../ckEditorSmall.vue';

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
  const accordionElement = event.target.closest('.accordion');
  if (accordionElement) {
    accordionElement.classList.toggle('active');
  }
}

function accordionAbilityOrigin(ability) {
    if (ability === 'FEAT') {
        return 'accordionFeat'
    } else if (ability === 'ITEM') {
        return 'accordionItem'
    } else if (ability === 'RACE') {
        return 'accordionRace'
    } else if (ability === 'OTHER') {
        return 'accordionOtherOrigin'
    } else {
        return 'accordionClass'
    }
}

function removeAccordion(index) {
    localCharacter.value.abilities.splice(index, 1);
    emit('update:characterData');
}

function addAccordion() {
    localCharacter.value.abilities.push(
        {
        "name": "XXX",
        "useTime": "Action",
        "levelRequirement": "OTHER",
        "description": "",
        "origin": "Class",
        "order": "9999"
      }
    );
    emit('update:characterData');
}

function updateText(newContent, index){
    localCharacter.value.abilities[index].description = newContent.value;
    emit('update:characterData');
}
</script>

<style scoped lang="scss">
.innerContainer.accordion{
    padding: 0;
    gap: 0;
    background-color: var(--colorBlueDark);
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
            .accordionRemove{
                position: absolute;
                right: 0;
                top: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 20px;
                height: 20px;
                background-color: var(--colorWhite);
                border-radius: 6px;
                padding: 0px;
                opacity: .25;
                transition: var(--transition);
                cursor: pointer;
                &:hover{
                    opacity: 1;
                }
                i{
                    font-size: 14px;
                    width: 100%;
                    text-align: center;
                    color: var(--colorBG1);
                }
            }
        }
        .accordionLevel{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 26px;
            width: 120px;
            margin: 5px 10px;
            background-color: var(--colorBlueDark);
            color: var(--colorWhite);
            border-radius: 6px;
            input{
                width: 100%;
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
                background-color: var(--colorBlueDark);
                input{
                    width: 100%;
                    text-align: center;
                }
                &.accordionOrder{
                    background-color: var(--colorWhite) !important;
                    color: var(--colorBG1);
                    width: 75px;
                    padding: 5px;
                }
            }
        }
        .accordionText{
            // background-color: var(--colorBG2);
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
    &.accordionFeat{
        background-color: var(--colorRations);
        .accordionContent .accordionHighlights div{
            background-color: #2a8756;
        }
        .accordionHead {
            .accordionToggle i{
                color: #2a8756;
            }
            .accordionLevel{
                background-color: #2a8756;
            }
        }
    }
    &.accordionRace{
        background-color: var(--colorSanityLoss);
        .accordionContent .accordionHighlights div{
            background-color: #93343c;
        }
        .accordionHead {
            .accordionToggle i{
                color: #93343c;
            }
            .accordionLevel{
                background-color: #93343c;
            }
        }
    }
    &.accordionItem{
        background-color: var(--colorSanityGain);
        .accordionContent .accordionHighlights div{
            background-color: #7038db;
        }
        .accordionHead {
            .accordionToggle i{
                color: #7038db;
            }
            .accordionLevel{
                background-color: #7038db;
            }
        }
    }
    &.accordionOtherOrigin{
        background-color: var(--colorBG3);
        .accordionContent .accordionHighlights div{
            background-color: var(--colorBG1);
        }
        .accordionHead {
            .accordionToggle i{
                color: var(--colorBG1);
            }
            .accordionLevel{
                background-color: var(--colorBG1);
            }
        }
    }
    &.accordionClass{
        background-color: rgba(14,116,144,.3);
        
    }
}
.accordionAdd{
    background-color: var(--colorBlueDark);
    border-radius: 6px;
    height: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: .25;
    margin-top: 10px;
    transition: var(--transition);
    cursor: pointer;
    &:hover{
        opacity: 1;
    }
}
</style>
