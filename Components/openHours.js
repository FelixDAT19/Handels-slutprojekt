function OpenHours({openHours}){
    return(
        <div className="openHours">

            <h2>Öppettider</h2>

            {openHours.map(({openHours,openDates}, g) => ( //maps out opening hours
                <div key={g}>
                    <p>{openDates} {openHours}</p>
                </div>
            ))}

        </div>
    )

}

export default OpenHours;