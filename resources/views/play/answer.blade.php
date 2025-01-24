<x-play-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">
                    @if ($isCorrectAnswer)
                        Correct!!!
                    @else
                        Incorrect...
                    @endif
                </h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Qustion：{{ $quiz['question'] }} </p>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Explanation：{{ $quiz['explanation'] }}</p>
            </div>
            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th
                                class="whitespace-nowrap w-10 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                ID</th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                Option</th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                Correct or InCorrect</th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                Your Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 4; $i++)
                            <tr>
                                <td class="px-4 py-3">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">{{ $quizOptions[$i]['content'] }}</td>
                                <td class="px-4 py-3">
                                    {{ $quizOptions[$i]['is_correct'] === 1 ? '⚪︎' : '×' }}</td>
                                <td class="px-4 py-3">
                                    {{ in_array($quizOptions[$i]['id'], $selectedOptions) ? '⚪︎' : '×' }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                <button
                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Next
                    Question</button>
            </div>
        </div>
    </section>
</x-play-layout>
