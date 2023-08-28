<div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="{{$id}}">
    <div class="relative w-auto my-6 mx-auto max-w-3xl">
        <!--content-->
        <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <!--header-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                <h3 class="text-3xl font-semibold">
                    {{$title}}
                </h3>
                <button class="p-1 ml-auto border-0 text-3xl font-semibold text-black opacity-5 float-right leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('{{$id}}')">
                    X
                </button>
            </div>
            <!--body-->
            <div class="relative p-6 flex-auto">
                <p class="my-4 text-slate-500 text-lg leading-relaxed">
                    {{$slot}}
                </p>
            </div>
            <!--footer-->
            <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('{{$id}}')">
                    Batal
                </button>
                <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="submit">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>
