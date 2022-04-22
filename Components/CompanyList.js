import React, {useState} from "react";


function CompanyList({company}) {// list with companies and what exact placements they have

  return (

    <nav className="companyDropdownNav">
    <label htmlFor="btn" className="first dropdownButton">Företag
    <span className="fas fa-caret-down"></span>
    </label>
    <input type="checkbox" id="btn" className="dropdownCheckbox"/>
    <ul className="menuCompany firstUl">

    {company.map(({name,placement}, o ) => (
            <li key={o} className="listItems firstLI">
               <label htmlFor="btn-2" className="second dropdownButton">{name}
               <span className="fas fa-caret-down"></span>
               </label>
               <input type="checkbox" id="btn-company" className="dropdownCheckbox"/>
               <ul className="menuCompany secondUl">
                    {placement.map((i, key) => 
                        <li key={key} className="listItems secondLI"><a href={`/company/${i.id}`} className="placeText">{i.id+ " "}</a></li>
                    )}
                  
               </ul>
            </li>
    ))}

    </ul>
 </nav>

  );
}

export default CompanyList;


