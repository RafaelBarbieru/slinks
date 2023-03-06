window.onload = () => {
    var divLink = document.getElementById("div_link");
    var divBlock = document.getElementById("div_block");
    var divGroup = document.getElementById("div_group");
    var selectBox = document.getElementById("object_type");
    var blocksSelectBox = document.getElementById("parent_block");
    var groupsSelectBox = document.getElementById("group_reference");
    var addButton = document.getElementById("add_btn");
    var nameInput = document.getElementById("inp_name");
    var linkInput = document.getElementById("inp_link");
    var parentGroupName = document.getElementById("$parent_group_name");
    var parentGroupId = document.getElementById("$parent_group_id");
    var backBtn = document.getElementById("back_btn");

    checkIfCanAdd();
    toggleFormGroups();
    if (!parentGroupName) {
        fetchBlockGroups();
    }

    if (blocksSelectBox) {
        blocksSelectBox.onchange = () => {
            fetchBlockGroups();
            toggleFormGroups();
        };
    }

    nameInput.oninput = () => {
        checkIfCanAdd();
    };

    linkInput.oninput = () => {
        checkIfCanAdd();
    };

    addButton.onclick = () => {
        // A small hack because PHP is a special snowflake that doesn't want to include disabled inputs in the POST request...
        selectBox.removeAttribute("disabled");
        blocksSelectBox.removeAttribute("disabled");
        groupsSelectBox.removeAttribute("disabled");
    };

    backBtn.onclick = (e) => {
        e.preventDefault();
        window.location.href = "/";
    };

    function toggleFormGroups() {
        switch (selectBox.value) {
            case "block":
                hideBlockDiv();
                hideGroupDiv();
                hideLinkDiv();
                checkIfCanAdd();
                break;
            case "group":
                showBlockDiv();
                hideGroupDiv();
                hideLinkDiv();
                checkIfCanAdd();
                break;
            case "link":
                showBlockDiv();
                showGroupDiv();
                showLinkDiv();
                checkIfCanAdd();
                break;
        }
    }

    function fetchBlockGroups() {
        let blockId = blocksSelectBox.value;
        fetch(`/groups/${blockId}`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        }).then((response) => {
            response.text().then((res) => {
                res = JSON.parse(res);
                let groups = res.response;
                updateGroupBox(groups);
                checkIfCanAdd();
            });
        });
    }
    function updateGroupBox(groups) {
        emptyGroupBox();
        groups.forEach((env) => createGroupOption(env));
    }
    function emptyGroupBox() {
        var i,
            L = groupsSelectBox.options.length - 1;
        for (i = L; i >= 0; i--) {
            groupsSelectBox.remove(i);
        }
    }
    function createGroupOption(env) {
        let newOption = document.createElement("option");
        let newOptionText = document.createTextNode(env.name);
        newOption.appendChild(newOptionText);
        newOption.setAttribute("value", env.id);
        if (parentGroupId && parentGroupId.value == env.id) {
            newOption.setAttribute("selected", "selected");
        }
        groupsSelectBox.appendChild(newOption);
    }
    function disableAddButton() {
        addButton.classList.remove("btn-slinks");
        addButton.classList.add("btn-slinks-disabled");
        addButton.disabled = true;
    }
    function enableAddButton() {
        addButton.classList.remove("btn-slinks-disabled");
        addButton.classList.add("btn-slinks");
        addButton.disabled = false;
    }
    function showLinkDiv() {
        divLink.style.display = "block";
    }
    function hideLinkDiv() {
        divLink.style.display = "none";
    }
    function showBlockDiv() {
        divBlock.style.display = "block";
    }
    function hideBlockDiv() {
        divBlock.style.display = "none";
    }
    function showGroupDiv() {
        divGroup.style.display = "block";
    }
    function hideGroupDiv() {
        divGroup.style.display = "none";
    }
    function checkIfCanAdd() {
        let canAdd = false;

        // Checking if the nameInput has three or more characters
        if (nameInput.value.length >= 3) {
            // Checking if there is a group selected (only if the user is trying to add a link)
            if (selectBox.value === "link") {
                canAdd = groupsSelectBox.value && linkInput.value.length >= 3;
            } else {
                canAdd = true;
            }
        }
        canAdd ? enableAddButton() : disableAddButton();
    }
};
