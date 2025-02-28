<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix Profile Select</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Style pour l'aperçu de l'image */
        #avatarPreview {
            max-width: 100px;
            max-height: 100px;
            margin-top: 0.5rem;
            border-radius: 0.375rem; /* corresponds to rounded-md */
        }
    </style>
</head>
<body class="bg-black h-screen flex items-center justify-center">

    <div class="container mx-auto text-center">
        <div class="text-white text-2xl mb-8">Créer votre compte</div>

        <div class="flex justify-center space-x-8">
            <div class="profile-container">
                <div class="w-32 h-32 bg-blue-500 rounded-md flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-16 h-16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                      </svg>
                </div>
                <div class="text-white mt-2">Steven</div>
            </div>

            <div class="profile-container">
                <div class="w-32 h-32 bg-yellow-300 rounded-md flex items-center justify-center">
                    <img src="https://static.wikia.nocookie.net/she-raandtheprincessesofpower/images/1/15/Adora-1.png/revision/latest?cb=20181121015314" alt="Avatar Adora" class="h-full w-full object-cover rounded-md" >
                </div>
                <div class="text-white mt-2">Will</div>
            </div>

            <div class="profile-container">
                <div class="w-32 h-32 rounded-md flex items-center justify-center" style="background: linear-gradient(45deg, #ff00ff, #00ffff);">
                  <span class="text-white text-4xl font-bold">kids</span>
                </div>
                <div class="text-white mt-2">Kids</div>
            </div>

            <div class="profile-container">
                <button id="addProfileBtn" class="w-32 h-32 bg-gray-700 rounded-md flex items-center justify-center hover:bg-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </button>
                <div class="text-white mt-2">Add Profile</div>
            </div>
        </div>

        <!-- Modal -->
        <div id="profileModal" class="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden modal-backdrop">
            <div class="bg-gray-800 rounded shadow-lg p-8 w-96">
                <h2 class="text-white text-xl mb-4">Add New Profile</h2>
                <form id="profileForm">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Name:</label>
                        <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-gray-700 text-white" placeholder="Enter profile name">
                    </div>

                     <div class="mb-4">
                        <label for="avatar" class="block text-gray-300 text-sm font-bold mb-2">Avatar:</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 text-white" />
                        <img id="avatarPreview" src="#" alt="Avatar Preview" class="hidden">
                    </div>


                    <div class="flex justify-end">
                        <button type="button" id="cancelBtn" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const addProfileBtn = document.getElementById('addProfileBtn');
        const profileModal = document.getElementById('profileModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const profileForm = document.getElementById('profileForm');
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatarPreview');



        addProfileBtn.addEventListener('click', () => {
            profileModal.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            profileModal.classList.add('hidden');
        });

        avatarInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    avatarPreview.classList.remove('hidden'); // Show the preview
                }

                reader.readAsDataURL(file); // Convert file to base64 string
            } else {
                avatarPreview.src = "#"; // Clear the preview
                avatarPreview.classList.add('hidden'); // Hide the preview
            }
        });

        profileForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const avatarFile = avatarInput.files[0];


            if (!name || !avatarFile) {
                alert('Please fill in all fields, including selecting an image.');
                return;
            }

            // **FormData for File Uploads:**  Crucially, use FormData
            const formData = new FormData();
            formData.append('name', name);
            formData.append('avatar', avatarFile);  // 'avatar' is the field name the backend expects

            try {
                 const response = await fetch('/api/profiles', { // Replace with your API endpoint
                     method: 'POST',
                     body: formData,  // Send the FormData
                 });

                if (response.ok) {
                    const newProfile = await response.json();
                    console.log('New profile created:', newProfile);

                    profileModal.classList.add('hidden');
                    document.getElementById('name').value = '';
                    avatarInput.value = ''; // Clear the file input
                    avatarPreview.src = "#";
                    avatarPreview.classList.add('hidden');

                    // TODO: Update the UI to show the new profile!

                } else {
                    console.error('Error creating profile:', response.status);
                    alert('Failed to create profile. See console.');
                }

            } catch (error) {
                console.error('Network error:', error);
                alert('Network error occurred.  See console.');
            }
        });
    </script>
</body>
</html>