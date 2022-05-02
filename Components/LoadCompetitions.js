

function LoadCompetitions({competitions}){ //import of all competitions
    
    return(
        <div className="competitionCompetitions">
        <nav className="companyDropdownNav">
            <label htmlFor="btn" className="first dropdownButton">Företags Tävlingar {/* dropdown button */}
            <span className="fas fa-caret-down"></span>
            </label>
            <input type="checkbox" id="btn" className="dropdownCheckbox"/>
            <ul className="menuCompany firstUl">

            {competitions.map(({company ,formUrl}, u)  => ( // puts the competition links inside of the dropdown 
                <li key={u} className="listItems firstLI"><a href={formUrl} className="competitionLink">{company.name}</a></li>
            ))}    
        
            </ul>
     </nav>
     </div>

    )
   

}

export default LoadCompetitions;

