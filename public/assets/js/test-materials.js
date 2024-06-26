let questionCount = 0;
let questions = [];
let isCreating = false; // if true, it means the user is creating a new question. if false, it means the user is editing an existing question
let sortableInstance = null;

const getTest = () => {
  let contentQuestion = [];

  contentQuestion = questions.map((question, index) => {
    return {
      sequence: index + 1,
      content: question.text,
      options: question.options.map((opt, index) => {
        return {
          answer: opt,
          correct: question.correctOption === index ? 1 : 0,
        };
      }),
    };
  });

  // console.log(contentQuestion);
  return contentQuestion;
};

const prepareFormData = (event, type_test) => {
  event.preventDefault();
  const dataTest = getTest();
  if (dataTest.length === 0) {
    alert("Soal pre-test tidak boleh kosong");
    console.log("KOSONG");
    return;
  }
  if (isCreating) {
    alert("Please save the current question before adding a new one.");
    return;
  }
  const jsonData = JSON.stringify({ type_test, dataTest });
  document.getElementById("content").value = jsonData;
  console.log("ISI");
  event.target.submit();
};

const addQuestion = () => {
  if (isCreating) {
    alert("Please save the current question before adding a new one.");
    return;
  }

  questionCount++;
  const questionId = `question-${questionCount}`;
  const container = document.getElementById("question-container");
  const questionHtml = getUnsavedQuestionHtml(questionId, questionCount);
  container.insertAdjacentHTML("beforeend", questionHtml);
  updateQuestionSequences();
  isCreating = true;
  destroySortable();
  console.log(isCreating);
  console.log(questions);
};

const getUnsavedQuestionHtml = (questionId, questionSequence) => `
  <div id="${questionId}" class="p-4 bg-gray-100 rounded shadow-inner">
    <label class="block mb-2">Pertanyaan ${questionSequence}:</label>
    <div>
      <label class="block mb-2 text-md text-gray-700 font-medium dark:text-white">Soal</label>
      <input
        type="text"
        id="question-text-${questionId}"
        placeholder="Tuliskan Soal"
        class="question-text py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
      />
    </div>
    <label class="block py-2 text-md text-gray-700 font-medium dark:text-white">Options:</label>
    <div class="space-y-4">
      ${["A", "B", "C", "D"]
        .map(
          (opt) => `
        <div class="flex items-center space-x-5">
          <input type="radio" name="correct-${questionId}" value="${opt}" id="correct-${opt}-${questionId}" />
          <input
            type="text"
            id="option-${opt}-${questionId}"
            class="option-text border border-gray-300 p-2 rounded-md w-full"
            placeholder="Option ${opt}"
          />
        </div>
      `
        )
        .join("")}
      <button
        class="py-2 px-3 text-sm font-semibold text-gray-800 bg-green-400 rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-500 dark:hover:bg-green-500 dark:focus:ring-green-500"
        onclick="saveQuestion('${questionId}')"
      >
        Save Pertanyaan
      </button>
    </div>
  </div>
`;

const getSavedQuestionHtml = (question, questionSequence) => `
  <div class="p-4 rounded mb-2 relative">
    <button
      type="button"
      class="absolute top-2 right-2 flex flex-shrink-0 justify-center items-center gap-2 size-[38px] text-sm font-semibold rounded-full border border-transparent bg-yellow-400 text-gray-800 hover:bg-yellow-500"
      onclick="editQuestion('${question.id}')"
    >
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 size-4">
        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
      </svg>
    </button>
    <p class="text-lg text-gray-800 font-bold mb-2">Pertanyaan ${questionSequence}:</p>
    <p class="text-gray-800">${question.text}</p>
    <div class="ml-5">
      ${question.options
        .map(
          (opt, index) => `
        <p class="${
          (question.correctOption === index ? 1 : 0)
            ? "font-semibold text-green-500"
            : ""
        }">
          ${String.fromCharCode(65 + index)}. ${opt}
        </p>
      `
        )
        .join("")}
    </div>
  </div>
`;

const saveQuestion = (questionId) => {
  const questionText = document.getElementById(
    `question-text-${questionId}`
  ).value;
  const options = ["A", "B", "C", "D"].map(
    (opt) => document.getElementById(`option-${opt}-${questionId}`).value
  );
  const correctOption = ["A", "B", "C", "D"].findIndex(
    (opt) => document.getElementById(`correct-${opt}-${questionId}`).checked
  );

  if (
    !questionText ||
    options.some((option) => !option) ||
    correctOption === -1
  ) {
    alert("Please fill in all fields and select the correct option.");
    return;
  }

  const questionData = {
    id: questionId,
    text: questionText,
    options,
    correctOption,
  };
  const questionIndex = questions.findIndex((q) => q.id === questionId);

  if (questionIndex === -1) {
    questions.push(questionData);
  } else {
    questions[questionIndex] = questionData;
  }

  document.getElementById(questionId).innerHTML = getSavedQuestionHtml(
    questionData,
    questions.length
  );
  isCreating = false;
  console.log(isCreating);
  initializeSortable();
  updateQuestionSequences();
};
const saveQuestionOld = (questionId) => {
  const questionText = document.getElementById(
    `question-text-${questionId}`
  ).value;
  const options = ["A", "B", "C", "D"].map(
    (opt) => document.getElementById(`option-${opt}-${questionId}`).value
  );
  const correctOption = ["A", "B", "C", "D"].findIndex(
    (opt) => document.getElementById(`correct-${opt}-${questionId}`).checked
  );

  if (
    !questionText ||
    options.some((option) => !option) ||
    correctOption === -1
  ) {
    alert("Please fill in all fields and select the correct option.");
    return;
  }

  const questionData = {
    id: questionId,
    text: questionText,
    options,
    correctOption,
  };
  const questionIndex = questions.findIndex((q) => q.id === questionId);

  if (questionIndex === -1) {
    questions.push(questionData);
  } else {
    questions[questionIndex] = questionData;
  }

  document.getElementById(questionId).innerHTML = getSavedQuestionHtml(
    questionData,
    questions.length
  );
  isCreating = false;
  console.log(isCreating);
  initializeSortable();
  updateQuestionSequences();
};

const editQuestion = (questionId) => {
  if (isCreating) {
    alert("Please save the current question before editing another one.");
    return;
  }
  const questionIndex = questions.findIndex((q) => q.id === questionId);
  if (questionIndex !== -1) {
    const questionData = questions[questionIndex];
    const questionDiv = document.getElementById(questionId);
    questionDiv.innerHTML = getUnsavedQuestionHtml(
      questionId,
      questionIndex + 1
    );

    document.getElementById(`question-text-${questionId}`).value =
      questionData.text;
    questionData.options.forEach((opt, index) => {
      document.getElementById(
        `option-${String.fromCharCode(65 + index)}-${questionId}`
      ).value = opt;
    });
    document.getElementById(
      `correct-${String.fromCharCode(
        65 + questionData.correctOption
      )}-${questionId}`
    ).checked = true;
  }
  isCreating = true;
  destroySortable();
  console.log(isCreating);
};

const saveMaterialsTest = () => {
  alert("Materials-Test saved!");
  console.log(questions);
};

const updateQuestionSequences = () => {
  const questionContainer = document.getElementById("question-container");
  Array.from(questionContainer.children).forEach((questionDiv, index) => {
    const questionSequence = index + 1;
    const label = questionDiv.querySelector("label");
    if (label) {
      label.innerText = `Pertanyaan ${questionSequence}:`;
    }
    const questionIndex = questions.findIndex((q) => q.id === questionDiv.id);
    if (questionIndex !== -1) {
      questionDiv.innerHTML = getSavedQuestionHtml(
        questions[questionIndex],
        questionSequence
      );
    }
  });
};

const initializeSortable = () => {
  if (!isCreating && !sortableInstance) {
    sortableInstance = new Sortable(
      document.getElementById("question-container"),
      {
        animation: 150,
        onEnd: () => {
          const newQuestions = [];
          document
            .querySelectorAll("#question-container > div")
            .forEach((div, index) => {
              const questionId = div.id;
              const questionIndex = questions.findIndex(
                (q) => q.id === questionId
              );
              newQuestions[index] = questions[questionIndex];
            });
          questions = newQuestions;
          updateQuestionSequences();
        },
      }
    );
  }
};

const destroySortable = () => {
  if (sortableInstance) {
    sortableInstance.destroy();
    sortableInstance = null;
  }
};

document.addEventListener("DOMContentLoaded", () => {
  initializeSortable();
});
