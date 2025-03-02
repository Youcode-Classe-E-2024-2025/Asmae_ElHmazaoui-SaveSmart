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
<a href="/logout" class="text-white m-4">log out</a>
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
                @if (!$familyAccount)
                    <button id="addProfileBtn" class="w-32 h-32 bg-gray-700 rounded-md flex items-center justify-center hover:bg-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                    <div class="text-white mt-2">Add Profile</div>
                @else
                    <button id="editProfileBtn" class="w-32 h-32 bg-gray-700 rounded-md flex items-center justify-center hover:bg-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                    <div class="text-white mt-2">Edit Profile</div>

                    <form action="{{ route('FamilyAccount.destroy', $familyAccount->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce compte familial ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">Supprimer</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Modal -->
        <div id="profileModal" class="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden modal-backdrop">
            <div class="bg-gray-800 rounded shadow-lg p-8 w-96">
                <h2 class="text-white text-xl mb-4">
                    @if($familyAccount)
                        Edit Family Account
                    @else
                        Add New family acount
                    @endif
                </h2>
                <form id="profileForm"
                      action="@if($familyAccount) {{ route('FamilyAccount.update', $familyAccount->id) }} @else {{ route('FamilyAccount.store') }} @endif"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($familyAccount)
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Name:</label>
                        <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-gray-700 text-white" placeholder="Enter profile name" value="{{ $familyAccount ? $familyAccount->name : '' }}">
                    </div>

                    <div class="mb-4">
                        <label for="avatar" class="block text-gray-300 text-sm font-bold mb-2">Avatar:</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="shadow border rounded w-full py-2 px-3 text-black-700  focus:outline-none focus:shadow-outline bg-gray-700 text-white" />
                        @if($familyAccount && $familyAccount->avatar)
                            <img src="{{ asset('storage/' . $familyAccount->avatar) }}" alt="Current Avatar" class="mt-2 rounded-md w-20 h-20 object-cover">
                        @endif
                    </div>

                    <div class="flex justify-end">
                        <button type="button" id="cancelBtn" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            @if($familyAccount)
                                Update
                            @else
                                Create
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const addProfileBtn = document.getElementById('addProfileBtn');
        const editProfileBtn = document.getElementById('editProfileBtn');
        const profileModal = document.getElementById('profileModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const profileForm = document.getElementById('profileForm');

        if (addProfileBtn) {
            addProfileBtn.addEventListener('click', () => {
                profileModal.classList.remove('hidden');
            });
        }

        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', () => {
                profileModal.classList.remove('hidden');
            });
        }


        cancelBtn.addEventListener('click', () => {
            profileModal.classList.add('hidden');
        });


    </script>

</body>
</html>