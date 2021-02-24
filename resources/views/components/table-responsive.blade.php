<table class="overflow-x-auto w-full bg-white divide-y divide-gray-200">
    <thead class="bg-gray-50 text-gray-500 text-sm">
      <tr class="divide-x divide-gray-300">
        <th class="px-3 py-2 flex justify-center text-left text-xs text-gray-500 uppercase">
          <div class="bg-white border-2 rounded border-gray-400 w-5 h-5 flex flex-shrink-0 justify-center items-center focus-within:border-blue-500">
            <input type="checkbox" class="opacity-0 absolute" />
            <svg class="fill-current hidden w-3 h-3 text-green-500 pointer-events-none" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /></svg>
          </div>
        </th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Contraseña</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nick</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Imagen</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha creación</th>
        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
      </tr>
    </thead>
    <tbody class="text-gray-500 text-xs divide-y divide-gray-200">
      <tr class="text-center">
        <td class="py-3 flex justify-center">
          <div class="bg-white border-2 rounded border-gray-400 w-5 h-5 flex flex-shrink-0 justify-center items-center focus-within:border-blue-500">
            <input type="checkbox" class="opacity-0 absolute" />
            <svg class="fill-current hidden w-3 h-3 text-green-500 pointer-events-none" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /></svg>
          </div>
        </td>
        <td class="py-3">{{$user->id}}</td>
        <td class="py-3">{{$user->name}}</td>
        <td class="py-3">{{$user->email}}</td>
        <td class="py-3">{{$user->password}}</td>
        <td class="py-3">{{$user->type}}</td>
        <td class="py-3">{{$user->nick}}</td>
        <td class="py-3">{{$user->img}}</td>
        <td class="py-3">{{$user->create_at}}</td>
        <td class="py-3">
          <div class="flex justify-center space-x-1">
            <button class="border-2 border-indigo-200 rounded-md p-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
              </svg>
            </button>
            <button class="border-2 border-red-200 rounded-md p-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>