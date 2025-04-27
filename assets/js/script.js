document.addEventListener('DOMContentLoaded', () => {
    const getAdviceBtn = document.getElementById('getAdviceBtn');
    const saveAdviceBtn = document.getElementById('saveAdviceBtn');
    const adviceElement = document.getElementById('advice');
    const saveFactBtn = document.getElementById('saveFactBtn');
    const getFactBtn = document.getElementById('getFactBtn');
    const factElement = document.getElementById('fact');
    const savedFactsList = document.getElementById('savedFactsList');
    const savedAdviceList = document.getElementById('savedAdviceList');
    const dogTab = document.getElementById('dogTab');
    const catTab = document.getElementById('catTab');
    let currentFactApi = '';

    getAdviceBtn.addEventListener('click', async () => {
        const response = await fetch('https://api.adviceslip.com/advice');
        const data = await response.json();
        const advice = data.slip.advice;
        adviceElement.textContent = advice;
        saveAdviceBtn.style.display = 'inline';
    });

    saveAdviceBtn.addEventListener('click', () => {
        const advice = adviceElement.textContent;
        let savedAdvices = JSON.parse(localStorage.getItem('savedAdvices')) || [];
        savedAdvices.push(advice);
        localStorage.setItem('savedAdvices', JSON.stringify(savedAdvices));
        updateSavedAdvices();
    });

    function updateSavedAdvices() {
        savedAdviceList.innerHTML = '';
        let savedAdvices = JSON.parse(localStorage.getItem('savedAdvices')) || [];
        savedAdvices.forEach(advice => {
            const li = document.createElement('li');
            li.textContent = advice;
            savedAdviceList.appendChild(li);
        });
    }

    dogTab.addEventListener('click', () => {
        currentFactApi = 'https://dog-api.kinduff.com/api/facts';
        fetchFact();
    });

    catTab.addEventListener('click', () => {
        currentFactApi = 'https://catfact.ninja/fact';
        fetchFact();
    });

    getFactBtn.addEventListener('click', fetchFact);

    function fetchFact() {
        if (!currentFactApi) {
            alert('Выберите вкладку для получения факта');
            return;
        }

        fetch(currentFactApi)
            .then(response => response.json())
            .then(data => {
                const fact = currentFactApi.includes('dog') ? data.facts[0] : data.fact;
                factElement.textContent = fact;
                saveFactBtn.style.display = 'inline';
            });
    }

    saveFactBtn.addEventListener('click', () => {
        const fact = factElement.textContent;
        let savedFacts = JSON.parse(localStorage.getItem('savedFacts')) || [];
        savedFacts.push(fact);
        localStorage.setItem('savedFacts', JSON.stringify(savedFacts));
        updateSavedFacts();
    });

    function updateSavedFacts() {
        savedFactsList.innerHTML = '';
        let savedFacts = JSON.parse(localStorage.getItem('savedFacts')) || [];
        savedFacts.forEach(fact => {
            const li = document.createElement('li');
            li.textContent = fact;
            savedFactsList.appendChild(li);
        });
    }

    updateSavedFacts();
    updateSavedAdvices();
});
