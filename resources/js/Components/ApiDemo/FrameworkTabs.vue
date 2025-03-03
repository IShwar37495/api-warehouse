<template>
    <div
        id="implementation"
        class="mb-12 overflow-hidden bg-white border border-gray-200 shadow-sm dark:bg-gray-900 rounded-2xl dark:border-gray-700"
    >
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Framework Implementation
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-300">
                Select your preferred framework to see specific implementation
                details
            </p>
        </div>
        <div class="border-b border-gray-200 dark:border-gray-700">
            <div class="flex px-6 overflow-x-auto hide-scrollbar">
                <button
                    v-for="tab in frameworkTabs"
                    :key="tab.id"
                    @click="activeTab = tab.id"
                    :class="[
                        'py-4 px-4 font-medium border-b-2 transition-colors whitespace-nowrap flex items-center',
                        activeTab === tab.id
                            ? 'border-[#FE4D01] text-[#FE4D01]'
                            : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300',
                    ]"
                >
                    <span class="mr-2">{{ tab.name }}</span>
                </button>
            </div>
        </div>
        <div class="p-6 md:p-8">
            <div class="mb-4">
                <div class="flex items-center mb-2">
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        {{ activeTabData.name }} Implementation
                    </h3>
                    <span
                        class="ml-3 px-3 py-1 text-xs font-medium text-[#FE4D01] bg-orange-100 rounded-full dark:bg-orange-900 dark:text-orange-200"
                    >
                        Recommended
                    </span>
                </div>
                <p class="text-gray-600 dark:text-gray-300">
                    {{ activeTabData.description }}
                </p>
            </div>
            <div v-if="activeTab === 'vue'" class="relative space-y-6">
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex justify-between mb-3">
                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >CountrySelector.vue</span
                        >
                        <button
                            @click="copyVueCode"
                            class="p-1 text-gray-500 transition-colors rounded hover:text-[#FE4D01] dark:text-gray-400 dark:hover:text-white"
                            title="Copy to clipboard"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 16H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2H8a2 2 0 00-2-2V8a2 2 0 002-2h8a2 2 0 002 2v8a2 2 0 00-2 2H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2z"
                                />
                            </svg>
                        </button>

                        <div
                            v-if="copySuccess"
                            class="absolute px-2 py-1 text-sm text-white bg-green-500 rounded-md top-3 right-12"
                        >
                            Copied!
                        </div>
                    </div>
                    <pre
                        class="p-6 overflow-x-auto font-mono text-sm text-gray-900 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200"
                    >
<code>&lt;script setup&gt;
import { ref, onMounted } from 'vue'

const countries = ref([])
const selectedCountry = ref('')

onMounted(async () => {
  try {
    const response = await fetch('https://api.example.com/countries', {
      headers: {
        'Authorization': `Bearer ${bearerToken}`
      }
    })
    countries.value = await response.json()
  } catch (error) {
    console.error('Error fetching countries:', error)
  }
})
&lt;/script&gt;

&lt;template&gt;
  &lt;select v-model="selectedCountry" class="country-select" @change="(e) => setSelectedCountry(e.target.value)"&gt;
    &lt;option value="" disabled&gt;Select Country&lt;/option&gt;
    &lt;option v-for="country in countries" :value="country.code"&gt;
      {{  }}
    &lt;/option&gt;
  &lt;/select&gt;
&lt;/template&gt;</code>
          </pre>
                </div>
            </div>
            <div v-if="activeTab === 'jquery'" class="relative space-y-6">
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex justify-between mb-3">
                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >jQuery Implementation</span
                        >
                        <button
                            @click="copyJQueryCode"
                            class="p-1 text-gray-500 transition-colors rounded hover:text-[#FE4D01] dark:text-gray-400 dark:hover:text-white"
                            title="Copy to clipboard"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 16H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2H8a2 2 0 00-2-2V8a2 2 0 002-2h8a2 2 0 002 2v8a2 2 0 00-2 2H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2z"
                                />
                            </svg>
                        </button>
                        <div
                            v-if="copySuccess"
                            class="absolute px-2 py-1 text-sm text-white bg-green-500 rounded-md top-3 right-12"
                        >
                            Copied!
                        </div>
                    </div>
                    <pre
                        class="p-6 overflow-x-auto font-mono text-sm text-gray-900 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200"
                    >
<code>&lt;select id="countrySelect"&gt;&lt;/select&gt;

&lt;script&gt;
$(document).ready(function() {
  $.ajax({
    url: 'https://api.example.com/countries',
    headers: {
      'Authorization': 'Bearer ' + bearerToken
    },
    success: function(data) {
      $.each(data, function(index, country) {
        $('#countrySelect').append(
          $('&lt;option&gt;', {
            value: country.code,
            text: country.name
          })
        )
      })
    }
  })
})
&lt;/script&gt;</code>
          </pre>
                </div>
            </div>
            <div v-if="activeTab === 'react'" class="relative space-y-6">
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex justify-between mb-3">
                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >CountrySelector.jsx</span
                        >
                        <button
                            @click="copyReactCode"
                            class="p-1 text-gray-500 transition-colors rounded hover:text-[#FE4D01] dark:text-gray-400 dark:hover:text-white"
                            title="Copy to clipboard"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 16H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2H8a2 2 0 00-2-2V8a2 2 0 002-2h8a2 2 0 002 2v8a2 2 0 00-2 2H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2z"
                                />
                            </svg>
                        </button>
                        <div
                            v-if="copySuccess"
                            class="absolute px-2 py-1 text-sm text-white bg-green-500 rounded-md top-3 right-12"
                        >
                            Copied!
                        </div>
                    </div>
                    <pre
                        class="p-6 overflow-x-auto font-mono text-sm text-gray-900 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200"
                    >
<code>import { useState, useEffect } from 'react'

function CountrySelector() {
  const [countries, setCountries] = useState([])
  const [selectedCountry, setSelectedCountry] = useState('')

  useEffect(() => {
    fetch('https://api.example.com/countries', {
      headers: {
        'Authorization': `Bearer ${bearerToken}`
      }
    })
    .then(response => response.json())
    .then(data => setCountries(data))
    .catch(error => console.error('Error fetching countries:', error))
  }, [])

  return (
    &lt;select
      value={selectedCountry}
      onChange={(e) => setSelectedCountry(e.target.value)}
      className="country-select"
    &gt;
      &lt;option value="" disabled&gt;Select Country&lt;/option&gt;
      {countries.map(country => (
        &lt;option key={country.code} value={country.code}&gt;
          {country.name}
        &lt;/option&gt;
      ))}
    &lt;/select&gt;
  )
}</code>
          </pre>
                </div>
            </div>
            <div v-if="activeTab === 'vanilla'" class="relative space-y-6">
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex justify-between mb-3">
                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >country-selector.js</span
                        >
                        <button
                            @click="copyVanillaCode"
                            class="p-1 text-gray-500 transition-colors rounded hover:text-[#FE4D01] dark:text-gray-400 dark:hover:text-white"
                            title="Copy to clipboard"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 16H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2H8a2 2 0 00-2-2V8a2 2 0 002-2h8a2 2 0 002 2v8a2 2 0 00-2 2H6a2 2 0 00-2-2V6a2 2 0 002-2h8a2 2 0 002 2v12a2 2 0 00-2 2z"
                                />
                            </svg>
                        </button>
                        <div
                            v-if="copySuccess"
                            class="absolute px-2 py-1 text-sm text-white bg-green-500 rounded-md top-3 right-12"
                        >
                            Copied!
                        </div>
                    </div>
                    <pre
                        class="p-6 overflow-x-auto font-mono text-sm text-gray-900 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200"
                    >
<code>const loadCountries = async () => {
  try {
    const response = await fetch('https://api.example.com/countries', {
      headers: {
        'Authorization': `Bearer ${bearerToken}`
      }
    })
    const countries = await response.json()
    const select = document.getElementById('countrySelect')

    // Clear any existing options
    select.innerHTML = '&lt;option value="" disabled selected&gt;Select Country&lt;/option&gt;'

    countries.forEach(country => {
      const option = document.createElement('option')
      option.value = country.code
      option.textContent = country.name
      select.appendChild(option)
    })

    // Add event listener
    select.addEventListener('change', (e) => {
      console.log('Selected country:', e.target.value)
    })
  } catch (error) {
    console.error('Error:', error)
  }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', loadCountries)</code>
          </pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

const activeTab = ref("vue");
const bearerToken = ref("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...");

const frameworkTabs = [
    { id: "vue", name: "Vue" },
    { id: "react", name: "React" },
    { id: "jquery", name: "jQuery" },
    { id: "vanilla", name: "Vanilla JS" },
];

// Use computed property for activeTabData to dynamically update based on activeTab
const activeTabData = computed(() => {
    const tabData = {
        vue: {
            name: "Vue",
            description: "Implementation using Vue.js framework",
        },
        react: {
            name: "React",
            description: "Implementation using React framework",
        },
        jquery: {
            name: "jQuery",
            description: "Implementation using jQuery library",
        },
        vanilla: {
            name: "Vanilla JS",
            description: "Implementation using plain JavaScript",
        },
    };
    return tabData[activeTab.value];
});

// These variables are only used for copy functionality, not for live demo
const copySuccess = ref(false);

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
    copySuccess.value = true;
    setTimeout(() => {
        copySuccess.value = false;
    }, 2000);
};

const copyVueCode = () => {
    copyToClipboard(`<script setup>
import { ref, onMounted } from 'vue'

const countries = ref([])
const selectedCountry = ref('')

onMounted(async () => {
  try {
    const response = await fetch('https://api.example.com/countries', {
      headers: {
        'Authorization': \`Bearer ${bearerToken.value}\`
      }
    })
    countries.value = await response.json()
  } catch (error) {
    console.error('Error fetching countries:', error)
  }
})


<template>
  <select v-model="selectedCountry" class="country-select" @change="(e) => setSelectedCountry(e.target.value)">
    <option value="" disabled>Select Country</option>
    <option v-for="country in countries" :value="country.code">
      {{ country.name }}
    </option>
  </select>
</template>`);
};

const copyJQueryCode = () => {
    copyToClipboard(`<select id="countrySelect"></select>

$(document).ready(function() {
  $.ajax({
    url: 'https://api.example.com/countries',
    headers: {
      'Authorization': 'Bearer ' + bearerToken
    },
    success: function(data) {
      $.each(data, function(index, country) {
        $('#countrySelect').append(
          $('<option>', {
            value: country.code,
            text: country.name
          })
        )
      })
    }
  })
})
`);
};

const copyReactCode = () => {
    copyToClipboard(`import { useState, useEffect } from 'react'

function CountrySelector() {
  const [countries, setCountries] = useState([])
  const [selectedCountry, setSelectedCountry] = useState('')

  useEffect(() => {
    fetch('https://api.example.com/countries', {
      headers: {
        'Authorization': \`Bearer ${bearerToken.value}\`
      }
    })
    .then(response => response.json())
    .then(data => setCountries(data))
    .catch(error => console.error('Error fetching countries:', error))
  }, [])

  return (
    <select
      value={selectedCountry}
      onChange={(e) => setSelectedCountry(e.target.value)}
      className="country-select"
    >
      <option value="" disabled>Select Country</option>
      {countries.map(country => (
        <option key={country.code} value={country.code}>
          {country.name}
        </option>
      ))}
    </select>
  )
}`);
};

const copyVanillaCode = () => {
    copyToClipboard(`const loadCountries = async () => {
  try {
    const response = await fetch('https://api.example.com/countries', {
      headers: {
        'Authorization': \`Bearer ${bearerToken.value}\`
      }
    })
    const countries = await response.json()
    const select = document.getElementById('countrySelect')

    // Clear any existing options
    select.innerHTML = '<option value="" disabled selected>Select Country</option>'

    countries.forEach(country => {
      const option = document.createElement('option')
      option.value = country.code
      option.textContent = country.name
      select.appendChild(option)
    })

    // Add event listener
    select.addEventListener('change', (e) => {
      console.log('Selected country:', e.target.value)
    })
  } catch (error) {
    console.error('Error:', error)
  }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', loadCountries)`);
};
</script>

<style scoped>
.country-select {
    @apply w-full p-3 border border-gray-300 rounded-lg bg-white dark:bg-gray-800 dark:border-gray-700 focus:border-[#FE4D01] focus:ring-2 focus:ring-[#FE4D01]/30 transition;
}

pre {
    @apply overflow-x-auto p-6 rounded-lg text-sm leading-relaxed;
}

code {
    @apply font-mono;
}

nav button {
    @apply relative transition-colors duration-200;
}

nav button::after {
    @apply content-[''] absolute bottom-[-1px] left-0 right-0 h-0.5 bg-transparent transition-colors duration-200;
}

nav button:hover::after {
    @apply bg-[#FE4D01]/30;
}

.hide-scrollbar::-webkit-scrollbar {
    display: none;
}

.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
