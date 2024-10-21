<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Translate Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to update background color when a language is selected
            const languageButtons = document.querySelectorAll("input[name='target_language']");
            languageButtons.forEach(button => {
                button.addEventListener("change", function () {
                    updateSelectedButton();
                });
            });

            // Function to update the selected button style
            function updateSelectedButton() {
                languageButtons.forEach(button => {
                    const label = document.querySelector(`label[for="${button.id}"]`);
                    if (button.checked) {
                        label.classList.add("bg-green-500", "text-white");
                        label.classList.remove("bg-gray-200", "hover:bg-gray-300");
                    } else {
                        label.classList.add("bg-gray-200", "hover:bg-gray-300");
                        label.classList.remove("bg-green-500", "text-white");
                    }
                });
            }

            // Initial call to set the selected button on page load
            updateSelectedButton();
        });
    </script>
</head>

<body class="bg-gray-100 p-6">

    {{-- HEADER START --}}
    <div class="flex items-center justify-between p-2 mb-5">
        <div class="flex items-center space-x-2">
            <i class="fas fa-bars text-xl"></i>
            <div class="flex items-center space-x-1">
                <span class="text-blue-500 font-medium text-xl">G</span>
                <span class="text-red-500 font-medium text-xl">o</span>
                <span class="text-yellow-500 font-medium text-xl">o</span>
                <span class="text-blue-500 font-medium text-xl">g</span>
                <span class="text-green-500 font-medium text-xl">l</span>
                <span class="text-red-500 font-medium text-xl">e</span>
            </div>
            <span class="text-gray-700 text-xl">Translation</span>
        </div>
        <div class="flex items-center space-x-4">
            <i class="fas fa-cog text-xl text-gray-600"></i>
            <i class="fas fa-th text-xl text-gray-600"></i>
            <div class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center">
                <span class="text-blue-500 font-medium text-xl">B</span>
            </div>
        </div>
    </div>
    {{-- HEADER END --}}

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <!-- Title -->
        <h1 class="text-3xl font-extrabold text-center mb-6 text-gray-800">Google Translate Clone</h1>

        <!-- Form -->
        <form action="{{ route('translate') }}" method="POST">
            @csrf
            <!-- Language Selector -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded">Language Detection</button>
                </div>
                <div class="flex space-x-2">
                    <!-- Language buttons with background color change when selected -->
                    <input type="radio" id="indonesian" name="target_language" value="id" class="hidden" {{ old('target_language') == 'id' ? 'checked' : '' }}>
                    <label for="indonesian" class="px-4 py-2 rounded cursor-pointer hover:bg-gray-300 
                        {{ old('target_language') == 'id' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                        Indonesian
                    </label>

                    <input type="radio" id="english" name="target_language" value="en" class="hidden" {{ old('target_language') == 'en' ? 'checked' : '' }}>
                    <label for="english" class="px-4 py-2 rounded cursor-pointer hover:bg-gray-300 
                        {{ old('target_language') == 'en' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                        English
                    </label>

                    <input type="radio" id="french" name="target_language" value="fr" class="hidden" {{ old('target_language') == 'fr' ? 'checked' : '' }}>
                    <label for="french" class="px-4 py-2 rounded cursor-pointer hover:bg-gray-300 
                        {{ old('target_language') == 'fr' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                        French
                    </label>

                    <input type="radio" id="spanish" name="target_language" value="es" class="hidden" {{ old('target_language') == 'es' ? 'checked' : '' }}>
                    <label for="spanish" class="px-4 py-2 rounded cursor-pointer hover:bg-gray-300 
                        {{ old('target_language') == 'es' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                        Spanish
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Left Text Area for Input -->
                <textarea id="text" name="text" rows="4" required
                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Type here...">{{ old('text') }}</textarea>

                <!-- Right Text Area for Translated Output -->
                <div class="relative">
                    <textarea id="translatedText" name="translatedText" rows="4" disabled
                        class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Translation">{{ session('translatedText') ?? '' }}</textarea>
                    
                    <!-- Copy Button -->
                    <button id="copyButton" type="button" class="absolute right-3 top-3 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Copy
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-5">
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl focus:outline-none transform transition hover:scale-105">
                    Translate
                </button>
            </div>
        </form>

        @if (session('error'))
        <div class="mt-8 p-6 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow-lg">
            <p>{{ session('error') }}</p>
        </div>
        @endif
    </div>

    <!-- JavaScript to Handle Copy Functionality -->
    <script>
        document.getElementById("copyButton").addEventListener("click", function() {
            const translatedTextArea = document.getElementById("translatedText");
            // Set the value of the textarea to the translated text for copying
            const translatedText = translatedTextArea.value;

            // Create a temporary textarea to hold the text to copy
            const tempTextArea = document.createElement("textarea");
            tempTextArea.value = translatedText;
            document.body.appendChild(tempTextArea);

            // Select the text in the temporary textarea
            tempTextArea.select();
            tempTextArea.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the temporary textarea
            document.execCommand("copy");

            // Remove the temporary textarea
            document.body.removeChild(tempTextArea);

            // Optionally, show an alert or feedback
            alert("Text copied to clipboard!");
        });
    </script>
</body>

</html>