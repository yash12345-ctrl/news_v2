class SoundTrack {
	constructor(name, url) {
		this.name = name;
		this.url = url;
		this.audioCtx = null;
		this.audioBuf = null;
		this.track = null;
	}

	async load() {
		this.audioCtx = new AudioContext();

		const res = await fetch(this.url);
		const buf = await res.arrayBuffer();
		this.audioBuf = await this.audioCtx.decodeAudioData(buf);
	}

	async play(loop) {
		// Check if context is in suspended state (autoplay policy)
		if (this.audioCtx.state === "suspended") {
			this.audioCtx.resume();
			return;
		}
		this.track = new AudioBufferSourceNode(this.audioCtx, {
			buffer: this.audioBuf,
			loop: loop,
		});

		this.track.connect(this.audioCtx.destination);
		this.track.addEventListener("ended", (event) => {
			if (this.callback) this.callback();
		});

		this.track.start();
	}

	pause() {
		// @TODO track can be null, check why and handle it accordingly
		// right now for leaving this fix for later, I just added this check.
		if (this.track) {
			this.track.stop();
		}
	}

	onEnded(cb) {
		this.callback = cb;
	}
}